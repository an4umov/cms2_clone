<?php

namespace common\models\search;

use common\models\BlockField;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BlockFieldSearch represents the model behind the search form of `common\models\BlockField`.
 */
class BlockFieldSearch extends BlockField
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_id',], 'safe'],
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
        $query = BlockField::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['block_id' => $this->block_id,]);
        $query->orderBy(['sort' => SORT_ASC,]);

        return $dataProvider;
    }
}
