<?php

namespace frontend\models\search;

use common\models\ContentCustomTag;
use common\models\ContentFilter;
use common\models\CustomTag;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Content;

/**
 * ContentSearch represents the model behind the search form of `common\models\Content`.
 */
class ContentSearch extends Content
{
    public $tag;
    public $custom_tag_id;

    public $department_id;
    public $model_id;
    public $menu_id;
    public $tag_id;
    public $content_ids;
    public $content_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['type', 'in', 'range' => self::TYPES,],
            ['tag', 'trim',],
            [['department_id', 'menu_id', 'tag_id', 'model_id', 'tag', 'type', 'content_ids',], 'safe',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Content::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->type = $params['type'] ?? '';
        $this->tag = $params['tag'] ?? '';

        $this->tag_id = $params['tag_id'] ?? 0;
        $this->model_id = $params['model_id'] ?? 0;
        $this->content_ids = $params['content_ids'] ?? [];
        $this->content_id = $params['content_id'] ?? 0;

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->where([Content::tableName().'.deleted_at' => null,]);
/*
        if (!empty($this->tag) && $tagModel = CustomTag::find()->where(['is_active' => true, 'name' => $this->tag,])->select('id')->asArray()->one()) {
            $this->custom_tag_id = $tagModel['id'];
            $query->innerJoin(ContentCustomTag::tableName(), ContentCustomTag::tableName().'.content_id = '.Content::tableName().'.id');
            $query->andWhere([ContentCustomTag::tableName().'.custom_tag_id' => $tagModel['id'],]);
        }
*/
        if (!empty($this->content_id)) {
            $query->andWhere([Content::tableName() . '.id' => $this->content_id,]);
        } elseif (!empty($this->content_ids) && is_array($this->content_ids)) {
            $query->andWhere([Content::tableName() . '.id' => $this->content_ids,]);
        } else {
            if (!empty($this->tag_id) || !empty($this->model_id)) {
                $query->innerJoin(ContentFilter::tableName(), ContentFilter::tableName() . '.content_id = ' . Content::tableName() . '.id');

                if (!empty($this->tag_id) && !empty($this->model_id)) {
                    $query->innerJoin(ContentFilter::tableName().' AS cfm', ContentFilter::tableName().'.content_id = cfm.content_id AND cfm.type = :type2 AND cfm.list_id = :id2', [':type2' => ContentFilter::TYPE_MODEL, ':id2' => $this->model_id,]);

                    $query->andWhere([ContentFilter::tableName().'.list_id' => $this->tag_id, ContentFilter::tableName().'.type' => ContentFilter::TYPE_TAG,]);
                } elseif (!empty($this->tag_id)) {
                    $query->andWhere([ContentFilter::tableName().'.list_id' => $this->tag_id, ContentFilter::tableName().'.type' => ContentFilter::TYPE_TAG,]);
                } elseif (!empty($this->model_id)) {
                    $query->andWhere([ContentFilter::tableName().'.list_id' => $this->model_id, ContentFilter::tableName().'.type' => ContentFilter::TYPE_MODEL,]);
                }
            }
        }


        $query->andFilterWhere(['type' => $this->type,]);
        $query->orderBy([Content::tableName().'.updated_at' => SORT_DESC,]);

        return $dataProvider;
    }
}
