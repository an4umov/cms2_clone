<?php

namespace common\models\search;

use common\models\Articles;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ParserLrpartsItems;

/**
 * DepartmentMenuSearch represents the model behind the search form of `common\models\DepartmentMenu`.
 */
class ParserLrpartsItemsSearch extends ParserLrpartsItems
{
    public $isNameFromArticles = false;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rubric_id',], 'integer'],
            [['url', 'name',], 'safe'],
            [['is_active',], 'boolean'],
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
        $query = ParserLrpartsItems::find();

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

        $query->select(ParserLrpartsItems::tableName().'.*');

        // grid filtering conditions
        $query->andFilterWhere([
            ParserLrpartsItems::tableName().'.rubric_id' => $this->rubric_id,
        ]);

        if (!empty($this->is_active)) {
            $query->andWhere([
                ParserLrpartsItems::tableName().'.is_active' => true,
            ]);
        }

        if ($this->isNameFromArticles) {
            $query->leftJoin(Articles::tableName(), 'lower('.ParserLrpartsItems::tableName().'.code) = lower('.Articles::tableName().'.number)');
            $query->addSelect(Articles::tableName().'.name as article_name'); //http://lr.home/epc/14600
        }

        $query->andFilterWhere(['ilike', ParserLrpartsItems::tableName().'.name', $this->name])
            ->orderBy([ParserLrpartsItems::tableName().'.id' => SORT_ASC,])
            ->limit(null);

        return $dataProvider;
    }
}
