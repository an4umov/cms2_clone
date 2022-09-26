<?php

namespace cabinet\models;

use amnah\yii2\user\models\Profile;
use common\models\User;
use common\models\UserToken;
use yii\base\Model;

class UserInvite extends Model
{
    public $email = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'safe']
        ];
    }

    public function invite()
    {
        $existingUsers = User::find()
            ->with('profile')
            ->where(['email' => $this->email])
            ->indexBy('email')
            ->all();
        foreach ((array)$this->email as $email) {
            if (isset($existingUsers[$email])) {
                continue;
            }

            $user = new User();
            $user->email = $email;
            $user->role_id = 2;
            $user->status = User::STATUS_INVITED;
            $user->save(false);

            $profile = new Profile();
            $profile->setUser($user->id)->save(false);

            $token = UserToken::generate($user->id, UserToken::TYPE_INVITE);

            \Yii::$app->mailer
                ->compose('@common/mail/invite', [
                    'user' => $user,
                    'token' => $token,
                ])
                ->setTo($email)
                ->setSubject('Invite')
                ->send();
        }
        return array_values($existingUsers);
    }
}