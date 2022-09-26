<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_delivery".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property bool $is_main Основной адрес доставки
 * @property bool $is_post Использовать этот адрес для почтовой корреспонденции
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $street
 * @property string $house Дом
 * @property string $building Корпус
 * @property string $entrance Подъезд
 * @property string $apartment Квартира
 * @property string $structure Строение
 * @property string $floor Этаж
 * @property string $index Индекс
 * @property string $info Дополнительная информация
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property User $user
 */
class UserDelivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_delivery';
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
            [['title', 'country', 'region', 'city', 'street', 'house', 'building', 'structure', 'entrance', 'apartment', 'floor', 'index', 'info',], 'trim'],
            [['user_id', 'title', 'country', 'region', 'city', 'street', 'house'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['is_main', 'is_post'], 'boolean'],
            [['info'], 'string'],
            [['title'], 'string', 'max' => 150],
            [['country', 'region', 'city', 'street'], 'string', 'max' => 100],
            [['house', 'building', 'structure'], 'string', 'max' => 25],
            [['entrance', 'apartment', 'floor', 'index'], 'string', 'max' => 10],
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
            'title' => 'Название адреса',
            'is_main' => 'Основной адрес доставки',
            'is_post' => 'Использовать этот адрес для почтовой корреспонденции',
            'country' => 'Страна',
            'region' => 'Регион',
            'city' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'building' => 'Корпус',
            'entrance' => 'Подъезд',
            'apartment' => 'Квартира',
            'structure' => 'Строение',
            'floor' => 'Этаж',
            'index' => 'Индекс',
            'info' => 'Дополнительная информация',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'deleted_at' => 'Удален',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id',]);
    }

    public function delete()
    {
        $this->deleted_at = time();

        $deleted = $this->save(false);

        return $deleted;
    }

    public function initModel() : void
    {
        $this->id = 0;
        $this->is_main = false;
        $this->is_post = false;
    }
}
