<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content_item".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $type
 * @property int $created_at
 * @property int $updated_at
 * @property string $image [integer]
 * @property string $additional [varchar(64)]
 * @property Image $attachedImage
 * @property int $sort [smallint]
 * @property string $fa_icon [varchar(32)]
 * @property string $url [varchar(255)]
 *
 */
class ContentItem extends \yii\db\ActiveRecord
{

    const SESSION_KEY_TYPE = 'ci_type_';

    const TYPE_FOR_TABS = 1;
    const TYPE_FOR_ACCORDION = 2;
    const TYPE_FOR_TILE = 3;
    const TYPE_FOR_INFO_BLOCK = 4;
    const TYPE_FOR_SLIDER_TILE = 5;
    const TYPE_FOR_WIDGET = 6;
    const TYPE_FOR_WIDGET_IMAGES_TILE = 7;
    const TYPE_FOR_GALLERY = 8;

    /**
     * Правильность размера загружаемого изображения определяется по соотношению сторон.
     * Для каждого типа свое соотношение (либо оно отсутствует, если это не имеет значения)
     *
     * RATIO_ACCURACY - точность соотношения сторон, (+/-)
     */
    const RATIO_ACCURACY = 0.2;
    /**
     * Соотнощение для виджета слайдер
     */
    const RATIO_GALLERY = 3.98;


    // ERRORS

    /* неверное соотношение */
    const ERROR_INVALID_RATIO = 'invalid_ratio';
    const ERROR_INVALID_RATIO_MESSAGE = 'Неверное соотношение сторон';

    public $navId;
    public $active;
    public $uploadImage;

    private static $types = [
        self::TYPE_FOR_TABS => 'Вкладки',
        self::TYPE_FOR_ACCORDION => 'Аккордион',
        self::TYPE_FOR_TILE => 'Плитка',
        self::TYPE_FOR_INFO_BLOCK => 'Инфо-блоки',
        self::TYPE_FOR_SLIDER_TILE => 'Слайдер-плитка',
        self::TYPE_FOR_WIDGET => 'Виджет',
        self::TYPE_FOR_GALLERY => 'Слайдер'
    ];

    public static function types()
    {
        return self::$types;
    }

    public static function typeName($type)
    {
        return self::$types[$type];
    }

    private static $ratios = [
        self::TYPE_FOR_GALLERY => self::RATIO_GALLERY
    ];

    public static function getRatio($type)
    {
        return isset(self::$ratios[$type]) ? self::$ratios[$type] : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_item';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['type', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['type', 'created_at', 'updated_at', 'image', 'sort'], 'integer'],
            [['title', 'url'], 'string', 'max' => 255],
            [['fa_icon'], 'string', 'max' => 32],
            [['additional'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'type' => 'Type',
            'image' => 'Изображение',
            'additional' => 'Дополнительно',
            'url' => 'Урл для ссылки',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sort' => 'Сортировка',
            'fa_icon' => 'Иконка (fontawesome)',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->navId = 'tab' . uniqid() . '_' . $this->id;
    }

    public function getAttachedImage()
    {
        return $this->hasOne(Image::class, ['id' => 'image']);
    }

    public function imagesList()
    {
        if (! is_null($this->attachedImage)) {
            return [
                $this->attachedImage->fullPath
            ];
        }
        return [];
    }
}
