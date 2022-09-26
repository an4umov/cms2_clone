<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CatalogLinktagDepartment;

/**
 * CatalogLinktagDepartmentSearch represents the model behind the search form of `common\models\CatalogLinktagDepartment`.
 */
class CatalogLinktagDepartmentSearch extends CatalogLinktagDepartment
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link_tag',], 'safe'],
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
        $query = CatalogLinktagDepartment::find();

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

        $query->andFilterWhere(['ilike', 'link_tag', $this->link_tag]);

        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getLinkTagOptions() : array
    {
        $options = [];
        $rows = CatalogLinktagDepartment::find()->select('link_tag')->distinct()->asArray()->column();

        foreach ($rows as $row) {
            $options[$row] = $row;
        }

        return $options;
    }
}
