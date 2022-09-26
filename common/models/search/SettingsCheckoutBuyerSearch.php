<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SettingsCheckoutBuyer;

/**
 * SettingsCheckoutBuyerSearch represents the model behind the search form of `common\models\SettingsCheckoutBuyer`.
 */
class SettingsCheckoutBuyerSearch extends SettingsCheckoutBuyer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['settings_checkout_id', 'reference_buyer_id',], 'integer'],
            [['is_active',], 'boolean'],
            [['data'], 'safe'],
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
        $query = SettingsCheckoutBuyer::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'settings_checkout_id' => $this->settings_checkout_id,
            'reference_buyer_id' => $this->reference_buyer_id,
            'is_active' => $this->is_active,
        ]);
        $query->orderBy(['reference_buyer_id' => SORT_ASC,]);

        return $dataProvider;
    }
}
