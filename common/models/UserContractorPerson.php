<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_contractor_person".
 *
 * @property int $id
 * @property int $user_id
 * @property bool $is_default Выбирать по умолчанию
 * @property bool $is_active Активен
 * @property string $firstname
 * @property string $lastname
 * @property string $secondname
 * @property string $address
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property User $user
 * @property UserContractorPayment $payments
 */
class UserContractorPerson extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_contractor_person';
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
            [['is_default', 'is_active'], 'boolean'],
            [['firstname', 'lastname', 'secondname'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'is_default' => 'Выбирать по умолчанию',
            'is_active' => 'Активен',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'secondname' => 'Отчество',
            'address' => 'Адрес',
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
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPayments()
    {
        return $this->hasMany(UserContractorPayment::class, ['person_id' => 'id', 'user_id' => 'user_id',])->where([UserContractorPayment::tableName().'.deleted_at' => null,]);
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
        $this->is_default = false;
        $this->is_active = true;
    }
}
