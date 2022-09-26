<?php


namespace common\models;


use yii\data\ActiveDataProvider;

class WidgetSearch extends Widget
{
    public function search($params)
    {
        $query = Widget::find();

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
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//        ]);

        return $dataProvider;

    }
}