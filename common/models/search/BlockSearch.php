<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Block;

/**
 * BlockSearch represents the model behind the search form of `common\models\Block`.
 */
class BlockSearch extends Block
{
    public $blockType;

    /**
     * @return mixed
     */
    public function getBlockType()
    {
        return $this->blockType;
    }

    /**
     * @param mixed $blockType
     */
    public function setBlockType($blockType): void
    {
        $this->blockType = $blockType;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name',], 'safe'],
            ['blockType', 'in', 'range' => self::TYPES,],
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
        $query = Block::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['ilike', 'name', $this->name,])
            ->andFilterWhere(['type' => $this->blockType,]);

        return $dataProvider;
    }
}
