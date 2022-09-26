<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_contractor_payment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $entity_id
 * @property int $person_id
 * @property string $type
 * @property bool $is_default Основная форма
 * @property string $bik
 * @property string $correspondent_account
 * @property string $bank
 * @property string $payment_account Расчётный счёт
 * @property string $number
 * @property int $month
 * @property int $year
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property User $user
 * @property UserContractorEntity $entity
 * @property UserContractorPerson $person
 */
class UserContractorPayment extends \yii\db\ActiveRecord
{
    const TYPE_TRANSFER = 'transfer';
    const TYPE_CASH = 'cash';
    const TYPE_CARD = 'card';
    const TYPES = [self::TYPE_TRANSFER, self::TYPE_CASH, self::TYPE_CARD,];

    private $_types;

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_TRANSFER => 'Банковский перевод',
            self::TYPE_CASH => 'Наличные',
            self::TYPE_CARD => 'Банковская карта',
        ];
    }

    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        return $this->_types;
    }

    public function getPersonTypeOptions() : array
    {
        $types = $this->_types;
        unset($types[self::TYPE_TRANSFER]);

        return $types;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_contractor_payment';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        return $this->_types[$type];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type',], 'required'],
            [['user_id', 'entity_id', 'person_id', 'month', 'year', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['user_id', 'entity_id', 'person_id', 'month', 'year', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['type'], 'string'],
            ['type', 'in', 'range' => self::TYPES,],
            [['is_default'], 'boolean'],
            [['bik', 'correspondent_account'], 'string', 'max' => 20],
            [['bank'], 'string', 'max' => 255],
            [['payment_account', 'number'], 'string', 'max' => 50],

            [['bik', 'correspondent_account', 'bank', 'payment_account',], 'required', 'when' => function($model) {
                return $model->type == self::TYPE_TRANSFER;
            }],
            [['number', 'month', 'year',], 'required', 'when' => function($model) {
                return $model->type == self::TYPE_CARD;
            }],

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
            'entity_id' => 'Юр. лицо',
            'person_id' => 'Частное лицо',
            'type' => 'Тип',
            'is_default' => 'Основная форма',

            'bik' => 'БИК',
            'correspondent_account' => 'Кор. счет',
            'bank' => 'Банк',
            'payment_account' => 'Расч. счет',

            'number' => 'Номер',
            'month' => 'Месяц',
            'year' => 'Год',

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntity()
    {
        return $this->hasOne(UserContractorEntity::class, ['id' => 'entity_id', 'user_id' => 'user_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(UserContractorPerson::class, ['id' => 'person_id', 'user_id' => 'user_id',]);
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
        $this->type = self::TYPE_TRANSFER;
    }

    /**
     * @return string
     */
    public function getInfo() : string
    {
        $info = '';
        switch ($this->type) {
            case self::TYPE_TRANSFER:
                $info = $this->getAttributeLabel('bik').': '.$this->bik.', '.$this->getAttributeLabel('correspondent_account').': '.$this->correspondent_account;
                break;
            case self::TYPE_CASH:
                $info = '';
                break;
            case self::TYPE_CARD:
                $info = $this->getAttributeLabel('number').': '.$this->number.', '.$this->month.'/'.$this->year;
                break;
        }

        return $info;
    }

    /**
     * @return array
     */
    public function getMonthOptions() : array
    {
        $options = [];

        foreach (range(1, 12, 1) as $month) {
            $options[$month] = $month < 10 ? '0'.$month : $month;
        }

        return $options;
    }

    /**
     * @return array
     */
    public function getYearOptions() : array
    {
        $options = [];
        $start = (int)date('Y');

        foreach (range($start, $start + 10, 1) as $year) {
            $options[$year] = $year;
        }

        return $options;
    }
}
