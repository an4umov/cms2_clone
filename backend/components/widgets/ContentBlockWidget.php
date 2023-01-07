<?php

namespace backend\components\widgets;

use common\models\Content;
use common\models\ContentBlock;
use common\models\BlockField;
use common\models\BlockReadyField;
use common\models\FormField;
use yii\base\Widget;
use yii\web\NotFoundHttpException;

class ContentBlockWidget extends Widget
{
    /** @var array */
    public $block;
    /** @var int */
    public $index;
    /** @var bool */
    public $isContent;
    /** @var bool */
    public $expanded;
    /** @var Content */
    public $content;
    /** @var bool */
    public $isAjax;


    /** @var string */
    public $id = 'content-block-item';

    public function init()
    {
        parent::init();

        if (empty($this->block)) {
            throw new NotFoundHttpException('Отсутствует блок');
        }
        if (is_null($this->isContent)) {
            $this->isContent = true;
        }
        if (is_null($this->isAjax)) {
            $this->isAjax = false;
        }
        if (is_null($this->expanded)) {
            $this->expanded = [];
        }
    }

    public function run()
    {
        $fields = [];
        if ($this->block['content_block_type'] === ContentBlock::TYPE_BLOCK) {
            $fields = BlockField::find()->where(['block_id' => $this->block['id'], 'deleted_at' => null,])->orderBy(['sort' => SORT_ASC,])->all();
        } elseif ($this->block['content_block_type'] === ContentBlock::TYPE_BLOCK_READY) {
            $fields = BlockReadyField::find()->where(['block_id' => $this->block['id'],])->orderBy(['sort' => SORT_ASC,])->all();
        } elseif ($this->block['content_block_type'] === ContentBlock::TYPE_FORM) {
            $fields = FormField::find()->where(['form_id' => $this->block['id'],])->orderBy(['sort' => SORT_ASC,])->all();
        }

        foreach ($fields as $field) {
            if ($field->type === BlockField::TYPE_LIST || $field->type === BlockField::TYPE_RADIO) {
                $field->list = $field->getBlockFieldLists()->andWhere(['deleted_at' => null,])->all();
            } elseif ($field->type === BlockField::TYPE_VALUES_LIST) {
                $field->values_list = $field->getBlockFieldValuesLists()->all();
            }
        }

        return $this->render('content_block', [
            'block' => $this->block,
            'fields' => $fields,
            'index' => $this->index,
            'isContent' => $this->isContent,
            'expanded' => $this->expanded,
            'content' => $this->content,
            'isAjax' => $this->isAjax,
        ]);
    }
}
