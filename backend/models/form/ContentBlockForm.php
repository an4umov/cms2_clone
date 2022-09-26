<?php

namespace backend\models\form;

use common\models\Block;
use common\models\BlockReady;
use common\models\Content;
use common\models\ContentBlock;
use common\models\Form;
use yii\base\Model;


class ContentBlockForm extends Model
{
    public $type;
    public $contentType;
    public $content_id;
    public $block_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'block_id', 'content_id',], 'required'],
            ['type', 'in', 'range' => Block::TYPES,],
            ['contentType', 'in', 'range' => Content::TYPES,],
            [['block_id', 'content_id',], 'integer'],
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
            'content_id' => 'Контент',
        ];
    }

    public function save() : bool
    {
        $maxSort = (int) ContentBlock::find()->where(['content_id' => $this->content_id,])->max('sort');

        if ($this->type === Block::TYPE_BLOCK_READY) {
            $blockModel = BlockReady::findOne(['id' => $this->block_id, 'is_active' => true,]);

            if ($blockModel) {
                $model = new ContentBlock();
                $model->content_id = $this->content_id;
                $model->block_id = $blockModel->id;
                $model->sort = $maxSort + 1;
                $model->type = ContentBlock::TYPE_BLOCK_READY;

                return $model->save();
            }
        } elseif ($this->type === Block::TYPE_FORM) {
            $formModel = Form::findOne(['id' => $this->block_id, 'deleted_at' => null,]);

            if ($formModel) {
                $model = new ContentBlock();
                $model->content_id = $this->content_id;
                $model->block_id = $formModel->id;
                $model->sort = $maxSort + 1;
                $model->type = ContentBlock::TYPE_FORM;

                return $model->save();
            }
        } else {
            $blockModel = Block::findOne(['id' => $this->block_id, 'type' => $this->type, 'deleted_at' => null,]);

            if ($blockModel) {
                $isExist = false;
                //                if ($this->contentType !== Content::TYPE_NEWS) {
                //                    $isExist = ContentBlock::find()->where(['content_id' => $this->content_id, 'block_id' => $this->block_id,])->exists();
                //                }

                if (!$isExist) {
                    $model = new ContentBlock();
                    $model->content_id = $this->content_id;
                    $model->block_id = $blockModel->id;
                    $model->sort = $maxSort + 1;
                    $model->type = ContentBlock::TYPE_BLOCK;

                    return $model->save();
                }
            }
        }

        return false;
    }
}
