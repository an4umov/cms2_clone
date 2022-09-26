<?php

namespace common\models;

use amnah\yii2\user\models\Role;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * @property string $phone
 *
 * @property UsersEmail[] $listUsersEmail
 * @property UsersEmail $defaultUserEmail
 * @property AuthAssignment $authAssignment
 */

/**
 * @inheritdoc
 */
class UserLk extends \amnah\yii2\user\models\User
{
    const STATUS_INVITED = 3;

    public $roles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        $selfBehaviors = [
            'assignRoles' => [
                'class' => 'common\behaviors\AssignRoles',
                'in_attribute' => 'name',
                'out_attribute' => 'slug',
                'translit' => true
            ]
        ];

        return array_merge($selfBehaviors, parent::behaviors());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'id' => 'ID',
            'name' => 'ФИО',
            'email' => 'Email',
            'role' => 'Роль',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'created_at' => 'Дата регистрации',
            'logged_in_at' => 'Дата последнего входа',
            'newPassword' => 'Пароль',
            'newPasswordConfirm' => 'Повтор пароля',
            'roles' => 'Роли',
        ], parent::attributeLabels());

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['roles', 'each', 'rule' => ['string','max' => 100]],
            [['phone',], 'string', 'max' => 25,],
        ];

        return array_merge(parent::rules(), $rules);
    }

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_INACTIVE => 'Неактивен',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_UNCONFIRMED_EMAIL => 'Не подтвержден',
            self::STATUS_INVITED => 'Приглашен',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $userRoleID = self::getRoleIdByName('User');

        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE, 'role_id' => $userRoleID,]);
    }

    /**
     * @return array
     */
    public static function roles()
    {
        return ArrayHelper::map(Role::find()->all(), 'id', 'name');
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getStatusText()
    {
        return ArrayHelper::getValue(self::statuses(), $this->status);
    }

    /**
     * Получаем id роли по названию роли
     * @param $name
     * @return int|null
     */
    public static function getRoleIdByName($name)
    {
        /** @var Role $role */
        $role = Role::find()->where(['name' => $name,])->one();

        return empty($role) ? null : $role->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignment()
    {
        return $this->hasOne(AuthAssignment::class, ['user_id' => 'id']);
    }

    public function beforeValidate()
    {
        if (empty($this->role_id)) {
            $this->role_id = 2;
        }

        return parent::beforeValidate();
    }

    /**
     * @param $password
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = \Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
