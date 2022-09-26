<?php

namespace common\models\search;

use common\models\ReferenceBuyer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ReferencesBuyerSearch
 *
 * @package common\models\search
 */
class ReferenceBuyerSearch extends ReferenceBuyer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class', 'name', 'is_active',], 'safe'],
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
     * @return string
     */
    public function getClassTitle() : string
    {
        return parent::getClassTitle();
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
        $query = ReferenceBuyer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['ilike', 'name', $this->name,])
            ->andFilterWhere(['is_active' => $this->is_active,]);
        $query->orderBy(['id' => SORT_ASC,]);

        return $dataProvider;
    }
}
