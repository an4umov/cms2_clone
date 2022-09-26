<?php

namespace common\models;

use common\components\Crypt;
use Yii;

/**
 * This is the model class for table "users_email".
 *
 * @property int $id
 * @property int $user_id id пользователя
 * @property string $email почтовый ящик пользователя
 * @property string $password пароль от ящика пользователя
 * @property bool $default не основной/основной
 * @property string $service сервис предоставивший почту
 *
 * @property User $user
 */
class UsersEmail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_email';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service'], 'required'],
            [['user_id'], 'integer'],
            [['email', 'service'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['password'], 'string'],
            [['default'], 'boolean'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'email' => 'Почта',
            'password' => 'Пароль',
            'default' => 'По-умолчанию',
            'service' => 'Сервис предоставивший почту',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->user_id = \Yii::$app->user->id;

        $this->password = Crypt::encrypt($this->password);
        return parent::beforeSave($insert);
    }

    /**
     * После поиска дешифруем пароль
     */
    public function afterFind()
    {
        $this->password = Crypt::decrypt($this->password);
        parent::afterFind();
    }

    /**
     * Возвращаем экземпляр модели
     * @return UsersEmail[]
     */
    public static function getEmails()
    {
        $userId = Yii::$app->user->id;
        $models = self::find()->where([
            'user_id' => $userId
        ])->all();

        return $models ?: null;
    }

    /**
     * Устанавливаем признак для почты по-умолчанию
     * @param $id
     * @return int
     */
    public static function setEmailDefault($id)
    {
        //устанавливаем всем записям кроме выбраной значение не по-умолчанию
        self::updateAll(['default' => false], 'id != :id', [':id' => $id]);
        return self::updateAll(['default' => true], ['id' => $id]);
    }
}
