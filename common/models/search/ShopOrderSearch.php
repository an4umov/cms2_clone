<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopOrder;

/**
 * ShopOrderSearch represents the model behind the search form of `common\models\ShopOrder`.
 */
class ShopOrderSearch extends ShopOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'coupon_id', 'event_id', 'discount', 'settings_delivery_id', 'settings_payment_id', 'created_at', 'updated_at'], 'integer'],
            [['coupon_cost', 'event_cost', 'discount_cost', 'total', 'total_cost', 'cargo_weight', 'cargo_length', 'cargo_height', 'cargo_width', 'cargo_volume'], 'number'],
            [['is_need_installation'], 'boolean'],
            [['email', 'phone', 'name', 'user_type', 'legal_type', 'legal_inn', 'legal_kpp', 'legal_organization_name', 'legal_address', 'legal_payment', 'legal_bik', 'legal_bank', 'legal_correspondent_account', 'legal_payment_account', 'legal_comment', 'delivery_comment', 'payment_comment', 'comment'], 'safe'],
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
        $query = ShopOrder::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'coupon_id' => $this->coupon_id,
            'coupon_cost' => $this->coupon_cost,
            'event_id' => $this->event_id,
            'event_cost' => $this->event_cost,
            'discount' => $this->discount,
            'discount_cost' => $this->discount_cost,
            'total' => $this->total,
            'total_cost' => $this->total_cost,
            'is_need_installation' => $this->is_need_installation,
            'cargo_weight' => $this->cargo_weight,
            'cargo_length' => $this->cargo_length,
            'cargo_height' => $this->cargo_height,
            'cargo_width' => $this->cargo_width,
            'cargo_volume' => $this->cargo_volume,
            'settings_delivery_id' => $this->settings_delivery_id,
            'settings_payment_id' => $this->settings_payment_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'user_type', $this->user_type])
            ->andFilterWhere(['ilike', 'legal_type', $this->legal_type])
            ->andFilterWhere(['ilike', 'legal_inn', $this->legal_inn])
            ->andFilterWhere(['ilike', 'legal_kpp', $this->legal_kpp])
            ->andFilterWhere(['ilike', 'legal_organization_name', $this->legal_organization_name])
            ->andFilterWhere(['ilike', 'legal_address', $this->legal_address])
            ->andFilterWhere(['ilike', 'legal_payment', $this->legal_payment])
            ->andFilterWhere(['ilike', 'legal_bik', $this->legal_bik])
            ->andFilterWhere(['ilike', 'legal_bank', $this->legal_bank])
            ->andFilterWhere(['ilike', 'legal_correspondent_account', $this->legal_correspondent_account])
            ->andFilterWhere(['ilike', 'legal_payment_account', $this->legal_payment_account])
            ->andFilterWhere(['ilike', 'legal_comment', $this->legal_comment])
            ->andFilterWhere(['ilike', 'delivery_comment', $this->delivery_comment])
            ->andFilterWhere(['ilike', 'payment_comment', $this->payment_comment])
            ->andFilterWhere(['ilike', 'comment', $this->comment]);

        return $dataProvider;
    }
}
