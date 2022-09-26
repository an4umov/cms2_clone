<?php

namespace common\models\search;

use common\models\BlockReady;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Block;

/**
 * BlockReadySearch represents the model behind the search form of `common\models\BlockReady`.
 */
class BlockReadySearch extends BlockReady
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
            [['name', 'global_type',], 'safe'],
            ['blockType', 'in', 'range' => Block::TYPES,],
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
        $query = BlockReady::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['ilike', 'name', $this->name,]);
        $query->andFilterWhere(['global_type' => $this->global_type,]);

        return $dataProvider;
    }
}
