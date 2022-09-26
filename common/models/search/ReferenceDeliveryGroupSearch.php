<?php

namespace common\models\search;

use common\models\ReferenceDelivery;
use common\models\ReferenceDeliveryGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ReferenceDeliveryGroupSearch
 *
 * @package common\models\search
 */
class ReferenceDeliveryGroupSearch extends ReferenceDeliveryGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'is_active',], 'safe'],
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
        $query = ReferenceDeliveryGroup::find();

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
