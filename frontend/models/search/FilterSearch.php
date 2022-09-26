<?php

namespace frontend\models\search;

use \common\models\ContentFilter;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Content;

/**
 * FilterSearch represents the model behind the search form of `common\models\Content`.
 */
class FilterSearch extends Content
{
    public $department_id;
    public $menu_id;
    public $tag_id;
    public $model_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_id', 'menu_id', 'tag_id', 'model_id',], 'safe',],
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
        $this->tag_id = $params['tag_id'] ?? 0;
        $this->model_id = $params['model_id'] ?? 0;

        $query = Content::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->where([Content::tableName().'.deleted_at' => null,]);
        if (!empty($this->tag_id) || !empty($this->model_id)) {
            $query->innerJoin(ContentFilter::tableName(), ContentFilter::tableName() . '.content_id = ' . Content::tableName() . '.id');
        }

        if (!empty($this->tag_id)) {
            $query->andWhere([ContentFilter::tableName().'.list_id' => $this->tag_id, ContentFilter::tableName().'.type' => ContentFilter::TYPE_TAG,]);
        }

        if (!empty($this->model_id)) {
            $query->andWhere([ContentFilter::tableName().'.list_id' => $this->model_id, ContentFilter::tableName().'.type' => ContentFilter::TYPE_MODEL,]);
        }

//        $query->andFilterWhere([Content::tableName().'.type' => $this->type,]);
        $query->orderBy([Content::tableName().'.updated_at' => SORT_DESC,]);

        return $dataProvider;
    }
}
