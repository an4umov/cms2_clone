<?php

namespace frontend\components\widgets;

use common\models\Content;
use common\models\ContentCustomTag;
use yii\base\Widget;

class LastNewsWidget extends Widget
{
    public $header = '';
    public $anonsCount = 0;
    public $isExternal = '';
    public $isForIndex = false;
    public $tags = [];

    public function run()
    {
        $query = Content::find();
        $query->with('contentBlocks');
        $query->where(['type' => Content::TYPE_NEWS, 'deleted_at' => null, 'is_index_page' => $this->isForIndex,]);
        if ($this->tags && is_array($this->tags)) {
            $tags = [];
            foreach ($this->tags as $tag) {
                if (!empty($tag)) {
                    $tags[] = $tag;
                }
            }

            if ($tags) {
                $query->innerJoin(ContentCustomTag::tableName(), ContentCustomTag::tableName().'.content_id = '.Content::tableName().'.id');
                $query->andWhere([ContentCustomTag::tableName().'.custom_tag_id' => $tags,]);
            }
        }
        $query->orderBy(['updated_at' => SORT_DESC,]);

        return $this->render('last_news', [
            'models' => $query->all(),
            'header' => $this->header,
            'anonsCount' => $this->anonsCount,
            'isExternal' => $this->isExternal,
        ]);
    }
}
