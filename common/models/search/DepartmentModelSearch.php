<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DepartmentModel;

/**
 * DepartmentModelSearch represents the model behind the search form of `common\models\DepartmentModel`.
 */
class DepartmentModelSearch extends DepartmentModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_id',], 'integer'],
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
        $query = DepartmentModel::find();

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
            'department_id' => $this->department_id,
        ])
        ->orderBy(['department_id' => SORT_ASC, 'id' => SORT_ASC,]);

        return $dataProvider;
    }
}
