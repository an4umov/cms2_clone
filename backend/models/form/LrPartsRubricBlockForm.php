<?php

namespace backend\models\form;

use common\models\Block;
use common\models\ContentBlock;
use common\models\ParserLrpartsRubricsBlock;
use yii\base\Model;


class LrPartsRubricBlockForm extends Model
{
    public $rubric_id;
    public $block_id;
    public $type;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'block_id', 'rubric_id',], 'required'],
            ['type', 'in', 'range' => Block::TYPES,],
            [['block_id', 'rubric_id',], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type' => 'Тип блока',
            'block_id' => 'Блок',
            'rubric_id' => 'Рубрика',
        ];
    }

    /**
     * @return bool
     */
    public function save() : bool
    {
        $maxSort = (int) ParserLrpartsRubricsBlock::find()->where(['rubric_id' => $this->rubric_id,])->max('sort');
        $blockModel = Block::findOne(['id' => $this->block_id, 'type' => $this->type, 'deleted_at' => null,]);

        if ($blockModel) {
            $model = new ParserLrpartsRubricsBlock();
            $model->rubric_id = $this->rubric_id;
            $model->block_id = $blockModel->id;
            $model->sort = $maxSort + 1;
            $model->type = ContentBlock::TYPE_BLOCK;

            return $model->save();
        }

        return false;
    }
}
