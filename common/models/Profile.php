<?php
namespace common\models;

/**
 * @inheritdoc
 */
class Profile extends \amnah\yii2\user\models\Profile
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'full_name' => 'ФИО',
        ];
    }
}
