<?php

namespace frontend\components\widgets;

use common\models\Content;
use common\models\ContentCustomTag;
use common\models\ContentFilter;
use yii\base\Widget;

class NewsTapeWidget extends Widget
{
    const LIMIT_DEFAULT = 10;

    public $header = '';
    public $limit = 0;
    public $offset = 0;
    public $isPageFilter = false;
    public $tags = [];
    public $departmentFilter = [];
    public $menuFilter = [];
    public $tagFilter = [];

    public function run()
    {
        $query = Content::find();
        $query->with('contentBlocks');
        $query->where([Content::tableName().'.type' => Content::TYPE_NEWS, Content::tableName().'.deleted_at' => null,]);
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

        if (!empty($this->departmentFilter) || !empty($this->menuFilter) || !empty($this->tagFilter)) {
            $query2 = ContentFilter::find();
            $query2->select('content_id');
            $query2->distinct(true);

            if (!empty($this->departmentFilter)) {
                $query2->orWhere(
                    'list_id IN (' . implode(',', $this->departmentFilter) . ') AND type = :depType',
                    [':depType' => ContentFilter::TYPE_DEPARTMENT,]
                );
            }
            if (!empty($this->menuFilter)) {
                $query2->orWhere(
                    'list_id IN (' . implode(',', $this->menuFilter) . ') AND type = :menuType',
                    [':menuType' => ContentFilter::TYPE_MENU,]
                );
            }
            if (!empty($this->tagFilter)) {
                $query2->orWhere(
                    'list_id IN (' . implode(',', $this->tagFilter) . ') AND type = :tagType',
                    [':tagType' => ContentFilter::TYPE_TAG,]
                );
            }

            $filterIds = $query2->column();

            if ($filterIds) {
                $query->andWhere([Content::tableName().'.id' => $filterIds,]);
            }
        }

        $query->orderBy([Content::tableName().'.updated_at' => SORT_DESC,]);

        if (!empty($this->limit) && $this->limit > 0) {
            $query->limit($this->limit);
        } else {
            $query->limit(self::LIMIT_DEFAULT);
        }
        if (!empty($this->offset) && $this->offset > 0) {
            $query->offset($this->offset);
        }

        return $this->render('news_tape', [
            'models' => $query->all(),
            'header' => $this->header,
        ]);
    }
}
