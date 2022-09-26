<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_contractor_entity".
 *
 * @property int $id
 * @property int $user_id
 * @property bool $is_default Выбирать по умолчанию
 * @property bool $is_active Активен
 * @property string $inn
 * @property string $name
 * @property string $kpp
 * @property string $ogrn
 * @property string $address
 * @property string $person Уполномоченное лицо
 * @property string $reason Действует на основании
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property User $user
 * @property UserContractorPayment $payments
 */
class UserContractorEntity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_contractor_entity';
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
            [['inn', 'name', 'kpp', 'ogrn', 'address', 'person', 'reason',], 'trim'],
            [['user_id', 'inn', 'name', 'kpp', 'ogrn', 'address'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['is_default', 'is_active'], 'boolean'],
            [['address'], 'string'],
            [['inn'], 'string', 'max' => 12],
            [['name', 'person', 'reason'], 'string', 'max' => 255],
            [['kpp'], 'string', 'max' => 9],
            [['ogrn'], 'string', 'max' => 13],
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
            'inn' => 'ИНН',
            'name' => 'Название',
            'kpp' => 'КПП',
            'ogrn' => 'ОГРН',
            'address' => 'Адрес регистрации',
            'person' => 'Уполномоченное лицо',
            'reason' => 'Действует на основании',
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
        return $this->hasMany(UserContractorPayment::class, ['entity_id' => 'id', 'user_id' => 'user_id',])->where([UserContractorPayment::tableName().'.deleted_at' => null,]);
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
