<?php

namespace cabinet\components;

use Yii;

/**
 * User component
 */
class UserLk extends \amnah\yii2\user\components\User
{
    public function getEmail()
    {
        /** @var \common\models\UserLk $user */
        $user = $this->getIdentity();

        return $user ? $user->email : '';
    }

    public function getPhone()
    {
        /** @var \common\models\UserLk $user */
        $user = $this->getIdentity();

        return $user ? $user->phone : '';
    }

    public function getStatusTitle() : string
    {
        /** @var \common\models\UserLk $user */
        $user = $this->getIdentity();

        return $user->getStatusText();
    }

    public function getCreatedAt() : string
    {
        /** @var \common\models\UserLk $user */
        $user = $this->getIdentity();

        return Yii::$app->formatter->asDateTime($user->created_at, 'php:d.m.Y H:i');
    }

    public function getUpdatedAt() : string
    {
        /** @var \common\models\UserLk $user */
        $user = $this->getIdentity();

        return Yii::$app->formatter->asDateTime($user->updated_at, 'php:d.m.Y H:i');
    }

    public function getLoggedInAt() : string
    {
        /** @var \common\models\UserLk $user */
        $user = $this->getIdentity();

        return Yii::$app->formatter->asDateTime($user->logged_in_at, 'php:d.m.Y H:i');
    }

}
