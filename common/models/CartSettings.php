<?php

namespace common\models;

use common\components\helpers\ParserHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * This is the model class for table "cart_settings".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $level
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $radio_text
 * @property int $sort
 * @property bool $is_active
 * @property bool $is_collapse
 * @property string $data JSON
 * @property string $type
 * @property int $created_at
 * @property int $updated_at
 */
class CartSettings extends \yii\db\ActiveRecord
{
    const LEVEL_1 = 1;
    const LEVEL_2 = 2;
    const LEVEL_3 = 3;
    const LEVEL_4 = 4;
    const LEVELS = [self::LEVEL_1, self::LEVEL_2, self::LEVEL_3, self::LEVEL_4,];

    const TYPE_CART = 'cart';
    const TYPE_CUSTOMER = 'customer';
    const TYPE_DELIVERY = 'delivery';
    const TYPE_PAYMENT = 'payment';
    const TYPE_CONFIRMATION = 'confirmation';
    const TYPES = [self::TYPE_CART, self::TYPE_CUSTOMER, self::TYPE_DELIVERY, self::TYPE_PAYMENT, self::TYPE_CONFIRMATION,];


    /**
     * @var UploadedFile
     */
    public $imageFile;

    /** @var Settings */
    public $globalSettings;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_settings';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @param string $status
     *
     * @return string
     */
    public static function getStatusTitle(string $status) : string
    {
        $titles = self::getStatusTitles();

        return $titles[$status] ?? 'Не определен';
    }

    /**
     * @return array
     */
    public static function getStatusTitles() : array
    {
        return [
            self::TYPE_CART => 'Корзина',
            self::TYPE_CUSTOMER => 'Покупатель',
            self::TYPE_DELIVERY => 'Получение',
            self::TYPE_PAYMENT => 'Оплата',
            self::TYPE_CONFIRMATION => 'Отправить',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'type', 'level', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['parent_id', 'level', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['level', 'name'], 'required'],
            ['level', 'in', 'range' => self::LEVELS,],
            [['description', 'data', 'image', 'type',], 'string'],
            [['is_active', 'is_collapse'], 'boolean'],
            [['name', 'image', 'radio_text',], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'level' => 'Уровень',
            'name' => 'Название',
            'description' => 'Описание',
            'image' => 'Изображение',
            'imageFile' => 'Изображение',
            'sort' => 'Сортировка',
            'radio_text' => 'Текст для радио кнопки',
            'is_active' => 'Активный',
            'is_collapse' => 'Сворачивать',
            'data' => 'Данные',
            'type' => 'Тип рубрики первого уровня',
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

    /**
     * @return string
     */
    public function getImageSrc() : string
    {
        $src = '';
        if (!empty($this->image)) {
            $path = \Yii::getAlias('@backendImages').DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$this->image;

            if (file_exists($path)) {
                $src =  '/img/files/'.$this->image;
            } else {
                $src = $path;
            }
        }

        return $src;
    }

    /**
     * @return string|null
     */
    public function upload() : ?string
    {
        if (!empty($this->imageFile) && $this->validate()) {
            $path = \Yii::getAlias('@backendImages').DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR;
            $name = $this->id.'_'.time().'.'.$this->imageFile->extension;
            $this->imageFile->saveAs($path.$name, false);

            return $name;
        } else {
            return null;
        }
    }

    /**
     * @return array
     */
    public function getAvailableStatuses() : array
    {
        $statutes = self::getStatusTitles();
        $rows = CartSettings::find()->select(['id', 'type',])->where(['level' => self::LEVEL_1,])->asArray()->all();

        foreach ($rows as $row) {
            if (isset($statutes[$row['type']]) && $this->id != $row['id']) {
                unset($statutes[$row['type']]);
            }
        }

        return $statutes;
    }

    /**
     * @return string
     */
    public function getSettingNameByID(int $id) : string
    {
        $row = CartSettings::find()->select(['name',])->where(['id' => $id,])->asArray()->one();
        if (empty($row)) {
            return false;
        }
        return $row['name'];
    }
}
