<?php


namespace common\models;


use yii\base\Model;

class TagSearchForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'string']
        ];
    }
}