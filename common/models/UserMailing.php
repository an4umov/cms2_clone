<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_mailing".
 *
 * @property int $id
 * @property int $user_id
 * @property int $lk_mailing_id
 * @property bool $is_enabled
 * @property string $email
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property LkMailing $lkMailing
 */
class UserMailing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_mailing';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'lk_mailing_id',], 'required'],
            [['user_id', 'lk_mailing_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'lk_mailing_id', 'created_at', 'updated_at'], 'integer'],
            [['is_enabled'], 'boolean'],
            [['email'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id',]],
            [['lk_mailing_id'], 'exist', 'skipOnError' => true, 'targetClass' => LkMailing::class, 'targetAttribute' => ['lk_mailing_id' => 'id',]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'lk_mailing_id' => 'Почтовая рассылка',
            'is_enabled' => 'Включено',
            'email' => 'Электронная почта',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLkMailing()
    {
        return $this->hasOne(LkMailing::class, ['id' => 'lk_mailing_id',]);
    }

    public function initModel() : void
    {
        $this->id = 0;
        $this->is_enabled = false;
    }
}
