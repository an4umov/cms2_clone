<?php

namespace common\models;

class LoginForm extends \amnah\yii2\user\models\forms\LoginForm
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить',
        ];
    }
}