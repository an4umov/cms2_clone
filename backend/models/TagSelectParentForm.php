<?php

namespace backend\models;

class TagSelectParentForm extends \yii\base\Model
{
    public $parent_id;

    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'parent_id' => 'ID родителя'
        ];
    }
}