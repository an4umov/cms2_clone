<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "favorite".
 *
 * @property int $id
 * @property int $user_id
 * @property int $articles_id
 * @property string $articles_number
 * @property int $created_at
 *
 * @property User $user
 */
class Favorite extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'favorite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'articles_id', 'articles_number', 'email'], 'required'],
            [['user_id', 'articles_id', 'created_at'], 'default', 'value' => null],
            [['user_id', 'articles_id', 'created_at'], 'integer'],
            [['articles_number'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id',],],
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
            'articles_id' => 'ID артикула',
            'articles_number' => 'Номер артикула',
            'created_at' => 'Создано',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id',]);
    }
}
