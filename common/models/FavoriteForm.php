<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Модель для формы обратной связи
 */
class FavoriteForm extends Model
{
    public $email;
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
        ];
    }
}