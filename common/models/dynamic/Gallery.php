<?php
namespace common\models\dynamic;

use \yii\base\Model;

class Gallery extends Model
{
    public $images = [];
    public $title;
    public $foreignText;
}