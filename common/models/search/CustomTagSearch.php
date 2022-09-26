<?php

namespace common\models\search;

use common\models\CustomTag;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;

/**
 * CustomTagSearch represents the model behind the search form of `common\models\CustomTag`.
 */
class CustomTagSearch extends CustomTag
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name',], 'safe'],
            [['is_active'], 'boolean'],
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
        $query = CustomTag::find();

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
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->orderBy(['updated_at' => SORT_DESC,]);

        return $dataProvider;
    }
}
