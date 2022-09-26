<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $type
 * @property string $data JSON
 * @property int $created_at
 * @property int $updated_at
 */
class Settings extends \yii\db\ActiveRecord
{
    const NEWS_COUNT_DEFAULT = 4;
    const CART_SUCCESS_DEFAULT = 'Спасибо, Ваш заказ отправлен';
    const CART_FAILURE_DEFAULT = 'Ошибка при отправке заказа';

    const CART_SUCCESS_MESSAGE_KEY = 'success_message';
    const CART_FAILURE_MESSAGE_KEY = 'failure_message';

    const TYPE_NEWS = 'news';
    const TYPE_ARTICLE = 'article';
    const TYPE_PAGE = 'page';
    const TYPE_CART = 'cart';

    const TYPES = [self::TYPE_NEWS, self::TYPE_ARTICLE, self::TYPE_PAGE, self::TYPE_CART,];

    private $_types;

    public $news_title;
    public $news_count;
    public $news_is_expand;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_NEWS => 'Агрегатор новостей',
            self::TYPE_ARTICLE => 'Статьи',
            self::TYPE_PAGE => 'Страницы',
            self::TYPE_CART => 'Корзина',
        ];
    }

    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        return $this->_types;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string {
        return $this->_types[$type] ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'data'], 'string'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['news_title', 'news_count', 'news_is_expand',], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'data' => 'Данные',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return !empty($this->data) ? Json::decode($this->data) : [];
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = Json::encode($data);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        parent::save($runValidation, $attributeNames);
    }
}
