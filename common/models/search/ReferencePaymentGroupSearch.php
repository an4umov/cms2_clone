<?php

namespace common\models\search;

use common\models\ReferencePayment;
use common\models\ReferencePaymentGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ReferencePaymentGroupSearch
 *
 * @package common\models\search
 */
class ReferencePaymentGroupSearch extends ReferencePaymentGroup
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
        $query = ReferencePaymentGroup::find();

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
