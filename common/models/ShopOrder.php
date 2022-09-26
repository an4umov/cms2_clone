<?php

namespace common\models;

use common\components\helpers\AppHelper;
use common\components\helpers\CartHelper;
use common\components\helpers\FormHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "shop_order".
 *
 * @property int $id
 * @property int $user_id
 * @property int $coupon_id Купон
 * @property double $coupon_cost Скидка по купону
 * @property int $event_id Акция
 * @property double $event_cost Скидка по акции
 * @property int $discount Текущая скидка на момент покупки
 * @property double $discount_cost Значение по текущей скидке
 * @property double $total Итого без учета скидок
 * @property double $total_cost Итого с учетом скидок
 * @property bool $is_need_installation Требуется услуга по установке приобретенных деталей?
 * @property double $cargo_weight Вес груза, кг
 * @property double $cargo_length Длина груза, м
 * @property double $cargo_height Высота груза, м
 * @property double $cargo_width Ширина груза, м
 * @property double $cargo_volume Объём груза, м3
 * @property string $email
 * @property string $phone
 * @property string $name
 * @property string $user_type
 * @property string $legal_type
 * @property string $legal_inn ИНН
 * @property string $legal_kpp КПП
 * @property string $legal_organization_name Наименование организации
 * @property string $legal_address Юр. адрес
 * @property string $legal_payment
 * @property string $legal_bik БИК
 * @property string $legal_bank Банк
 * @property string $legal_correspondent_account Корреспондентский счет
 * @property string $legal_payment_account Расчетный счет
 * @property string $legal_comment Комментарий
 * @property int $settings_payment_id Настройка корзины, оплата
 * @property int $settings_payment_type_id Настройка корзины, способ оплаты
 * @property int $settings_delivery_id Настройка корзины, доставка
 * @property string $delivery_type_name 
 * @property string $delivery_address Адрес доставки
 * @property string $delivery_apartment Номер квартиры
 * @property string $delivery_city Город доставки
 * @property string $delivery_index Индекс доставки
 * @property int $delivery_type_id Айди типа доставки
 * @property int $delivery_carrier_id Айди перевозчика
 * @property string $payment_comment Комментарий по оплате
 * @property string $comment Комментарий к заказу
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ShopOrderItem[] $shopOrderItems
 */
class ShopOrder extends \yii\db\ActiveRecord
{
    const USER_TYPE_PRIVATE_PERSON = 'private_person';
    const USER_TYPE_LEGAL_PERSON = 'legal_person';
    const USER_TYPES = [self::USER_TYPE_PRIVATE_PERSON, self::USER_TYPE_LEGAL_PERSON,];

    const LEGAL_TYPE_IP = 'ip';
    const LEGAL_TYPE_COMPANY = 'company';
    const LEGAL_TYPES = [self::LEGAL_TYPE_IP, self::LEGAL_TYPE_COMPANY,];

    const LEGAL_PAYMENT_BANK_TRANSFER = 'bank_transfer';
    const LEGAL_PAYMENTS = [self::LEGAL_PAYMENT_BANK_TRANSFER,];

    public $delivery_type_name = '';
    public $delivery_carrier_name = '';
    public $payment_type_name = '';
    public $payment_name = '';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_order';
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
    public function getUserTypeTitle($type) : string
    {
        $titles = [
            self::USER_TYPE_PRIVATE_PERSON => 'Физичеcкое лицо',
            self::USER_TYPE_LEGAL_PERSON => 'Юридическое лицо или ип',
        ];

        return $titles[$type] ?? 'Не указан';
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getLegalTypeTitle(string $type) : string
    {
        $titles = [
            self::LEGAL_TYPE_IP => 'Индивидуальный предприниматель',
            self::LEGAL_TYPE_COMPANY => 'Фирма, юридическое лицо',
        ];

        return $titles[$type] ?? 'Не определен';
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getLegalPaymentTitle(string $type) : string
    {
        $titles = [
            self::LEGAL_PAYMENT_BANK_TRANSFER => 'Оплата по безналичному расчету',
        ];

        return $titles[$type] ?? 'Не определен';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'coupon_id', 'event_id', 'discount', 'settings_delivery_id', 'delivery_type_id', 'delivery_carrier_id', 'settings_payment_id', 'settings_payment_type_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'coupon_id', 'event_id', 'discount', 'settings_delivery_id', 'delivery_type_id', 'delivery_carrier_id', 'delivery_index', 'settings_payment_id', 'settings_payment_type_id', 'created_at', 'updated_at'], 'integer'],
            [['coupon_cost', 'event_cost', 'discount_cost', 'total', 'total_cost', 'cargo_weight', 'cargo_length', 'cargo_height', 'cargo_width', 'cargo_volume'], 'number'],
            [['email', 'name'], 'required'],
            ['email', 'email'],
            [['user_type'], 'default', 'value' => null],
            [['is_need_installation'], 'boolean'],
            [['user_type', 'legal_type', 'legal_address', 'legal_payment', 'legal_comment', 'delivery_address', 'delivery_apartment', 'delivery_city', 'payment_comment', 'comment'], 'string'],
            [['email', 'phone'], 'string', 'max' => 150],
            [['name', 'legal_organization_name', 'legal_bik', 'legal_bank', 'legal_correspondent_account', 'legal_payment_account'], 'string', 'max' => 255],
            [['legal_inn', 'legal_kpp'], 'string', 'max' => 30],

            ['user_type', 'in', 'range' => self::USER_TYPES,],
            ['legal_type', 'in', 'range' => self::LEGAL_TYPES,],
            ['legal_payment', 'in', 'range' => self::LEGAL_PAYMENTS,],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'coupon_id' => 'Купон',
            'coupon_cost' => 'Скидка по купону',
            'event_id' => 'Акция',
            'event_cost' => 'Скидка по акции',
            'discount' => 'Текущая скидка на момент покупки',
            'discount_cost' => 'Значение по текущей скидке',
            'total' => 'Итого без учета скидок, руб',
            'total_cost' => 'Итого с учетом скидок, руб',
            'is_need_installation' => 'Требуется услуга?',
            'cargo_weight' => 'Вес груза, кг',
            'cargo_length' => 'Длина груза, м',
            'cargo_height' => 'Высота груза, м',
            'cargo_width' => 'Ширина груза, м',
            'cargo_volume' => 'Объём груза, м3',
            'email' => 'E-MAIL',
            'phone' => 'Телефон',
            'name' => 'Ваше имя',
            'user_type' => 'Тип покупателя',
            'legal_type' => 'Тип юр. лица',
            'legal_inn' => 'ИНН',
            'legal_kpp' => 'КПП',
            'legal_organization_name' => 'Наименование организации',
            'legal_address' => 'Юр. адрес',
            'legal_payment' => 'Оплата по безналичному расчету',
            'legal_bik' => 'БИК',
            'legal_bank' => 'Банк',
            'legal_correspondent_account' => 'Кор. счет',
            'legal_payment_account' => 'Расч. счет',
            'legal_comment' => 'Комментарий',
            'settings_delivery_id' => 'Настройка корзины, доставка',
            'delivery_index' => 'Индекс', 
            'delivery_address' => 'Адрес', 
            'delivery_apartment' => 'Номер квартиры', 
            'delivery_city' => 'Город доставки',
            'delivery_type_id' => 'Айди типа доставки', 
            'delivery_carrier_id' => 'Айди перевозчика',
            //'delivery_comment' => 'Комментарий по доставке',
            'settings_payment_id' => 'Настройка корзины, оплата',
            'settings_payment_type_id' => 'Настройка корзины, способ оплаты',
            'payment_comment' => 'Комментарий по оплате',
            'comment' => 'Комментарий к заказу',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return array
     */
    public function attributeHints()
    {
        return [
            'email' => 'Введите email',
            'phone' => 'Введите номер телефона',
            'name' => 'Как к Вам обращаться?',
            'legal_inn' => 'Введите ИНН',
            'legal_kpp' => 'Введите КПП',
            'legal_address' => 'Введите юридический адрес',
            'legal_bik' => 'Введите БИК',
            'legal_bank' => 'Введите наименование банка',
            'legal_correspondent_account' => 'Введите корреспондентский счет',
            'legal_payment_account' => 'Введите расчетный счет',
            'legal_comment' => 'Ваш комментарий',
            'legal_organization_name' => 'Введите наименование организации',
            'delivery_index' => 'Введите индекс', 
            'delivery_address' => 'Введите адрес', 
            'delivery_apartment' => 'Введите номер квартиры', 
            'delivery_city' => 'Куда доставляем?',
            'comment' => 'Ваш комментарий',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopOrderItems()
    {
        return $this->hasMany(ShopOrderItem::class, ['order_id' => 'id',]);
    }

    /**
     * @return bool
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function sendOrder() : bool
    {
        if ($this->save()) {
            $this->sendEmails([Yii::$app->params['adminEmail'], $this->email,]);
        } else {
            throw new BadRequestHttpException('Ошибка отправки заказа: '.print_r($this->getFirstErrors(), true));
        }

        return true;
    }

    /**
     * @param array $emails
     *
     * @throws NotFoundHttpException
     */
    public function sendEmails(array $emails) : void
    {
        $items = $this->getShopOrderItems()->asArray(true)->all();

        $params = ['order' => $this, 'items' => $items,];

        foreach ($emails as $email) {
            $isSended = AppHelper::sendMessage('shoporder', $email, 'Новый заказ от "'.Html::encode($this->name).'"', $params, true);

            if (!$isSended) {
                throw new NotFoundHttpException('Заказ не отправлен на адрес ' . $email);
            }
        }
    }

    /**
     * @return float
     */
    public function calcOrderDiscounts()
    {
        return 0;
    }

    /**
     * @return string
     */
    public function getUserName() : string
    {
        $user = null;

        if ($this->user_id) {
            $user = \amnah\yii2\user\models\User::findOne($this->user_id);
        }

        if ($user) {
            return $user->getDisplayName();
        }

        return 'Гость';
    }
}
