<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SettingsCheckout;

/**
 * SettingsCheckoutSearch represents the model behind the search form of `common\models\SettingsCheckout`.
 */
class SettingsCheckoutSearch extends SettingsCheckout
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['reference_partner_id',], 'integer'],
            [['is_default', 'is_active',], 'boolean'],
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
        $query = SettingsCheckout::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'reference_partner_id' => $this->reference_partner_id,
            'is_default' => $this->is_default,
            'is_active' => $this->is_active,
        ]);

        return $dataProvider;
    }
}
