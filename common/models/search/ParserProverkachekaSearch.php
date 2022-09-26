<?php

namespace common\models\search;

use common\models\ParserProverkacheka;
use yii\data\ActiveDataProvider;


/**
 * ParserProverkachekaSearch represents the model behind the search form of `common\models\ParserProverkacheka`.
 */
class ParserProverkachekaSearch extends ParserProverkacheka
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inn', 'type',], 'safe'],
            [['inn',], 'string', 'min' => 2,],
        ];
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
        $query = ParserProverkacheka::find();

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

        $query->orderBy(['created_at' => SORT_DESC,]);

        if (!empty($this->inn)) {
            $query->andWhere(['like', 'inn', $this->inn.'%', false]);
        }

        $query->andFilterWhere(['=', 'type', $this->type]);

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getFilterTypeOptions() : array
    {
        $options = [
            '' => 'Выбрать ...',
        ];
        $rows = self::find()->select('type')->distinct(true)->asArray()->column();

        foreach ($rows as $row) {
            if (!empty($row)) {
                $options[$row] = $row;
            }
        }

        return $options;
    }
}
