<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "user_contact".
 *
 * @property int $id
 * @property int $user_id
 * @property string $sex
 * @property string $firstname
 * @property string $lastname
 * @property string $secondname
 * @property string $phones JSON
 * @property string $email
 * @property string $position
 * @property string $info
 * @property bool $is_main
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property User $user
 */
class UserContact extends \yii\db\ActiveRecord
{
    const SEX_MALE = 'male';
    const SEX_FEMALE = 'female';

    const SEXES = [self::SEX_FEMALE, self::SEX_MALE,];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_contact';
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
            [['user_id'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['sex', 'phones', 'info'], 'string'],
            ['sex', 'in', 'range' => self::SEXES,],
            [['is_main',], 'boolean'],
            [['firstname', 'lastname', 'secondname'], 'string', 'max' => 50],
            [['email', 'position'], 'string', 'max' => 100],
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
            'sex' => 'Обращение',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'secondname' => 'Отчество',
            'phones' => 'Телефон',
            'email' => 'Email',
            'position' => 'Должность',
            'info' => 'Дополнительная информация',
            'is_main' => 'Основное контактное лицо',
            'created_at' => 'Создано',
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

    /**
     * @return array
     */
    public function getPhones() : array
    {
        $result = [];
        if (!empty($this->phones)) {
            $result = Json::decode($this->phones);
        }

        return $result;
    }

    /**
     * @param array $data
     */
    public function setPhones(array $data)
    {
        $this->phones = Json::encode($data);
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
        $this->sex = self::SEX_MALE;
        $this->is_main = false;
        $this->phones = $this->getPhones();
    }
}
