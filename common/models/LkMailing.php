<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "lk_mailing".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UserMailing[] $userMailing
 */
class LkMailing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lk_mailing';
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
            [['name', 'description', 'sort'], 'required'],
            [['description'], 'string'],
            [['sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['sort', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'sort' => 'Сортировка',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMailing()
    {
        return $this->hasMany(UserMailing::class, ['lk_mailing_id' => 'id',]);
    }
}
