<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "widget".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property int $type
 * @property int $created_at
 * @property int $updated_at
 *
 * @property WidgetContentItem[] $widgetContentItems
 * @property ContentItem[] $contentItems
 */
class Widget extends \yii\db\ActiveRecord
{
    public $items;

    /**
     * Виджет плитка из изображений с заголовком
     */
    const TYPE_IMAGES_TILE_ONLY_TITLE_1 = 1;

    /**
     * Виджет плитка из изображений с заголовком, но превью изображений будет делиться на группы по 7
     * картинок
     */
    const TYPE_IMAGES_TILE_ONLY_TITLE_2 = 2;

    /**
     * Виджет плитка из изображений с текстом слева
     */
    const TYPE_IMAGES_TILE_LEFT_TEXT = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'widget';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    public static $types = [
        self::TYPE_IMAGES_TILE_ONLY_TITLE_1 => 'Виджет текст с плиткой катринок (без текста)',
        self::TYPE_IMAGES_TILE_ONLY_TITLE_2 => 'Виджет текст с плиткой катринок (с группировкой превью)',
        self::TYPE_IMAGES_TILE_LEFT_TEXT => 'Виджет текст с плиткой катринок (текст слева)',
    ];

    /**
     * @var array
     */
    public static $shortcodes = [
        self::TYPE_IMAGES_TILE_ONLY_TITLE_1 => 'images_tile_widget',
        self::TYPE_IMAGES_TILE_ONLY_TITLE_2 => 'images_tile_widget',
        self::TYPE_IMAGES_TILE_LEFT_TEXT => 'images_tile_widget',
    ];

    /**
     * @return array
     */
    public static function types()
    {
        return self::$types;
    }

    /**
     * @param $typeId
     * @return mixed
     */
    public static function type($typeId)
    {
        return self::$types[$typeId];
    }

    /**
     * @param $typeId
     * @return mixed
     */
    public function shortcode()
    {
        return "[" . self::$shortcodes[$this->type] . " id=" . $this->id . "]";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['type', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['type', 'created_at', 'updated_at'], 'integer'],
            ['items', 'each', 'rule' => ['string']],
            [['title', 'description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'text' => 'Text',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'items' => 'Единицы контента',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentItems()
    {
        return $this->hasMany(ContentItem::class, ['id' => 'content_item_id'])->viaTable('widget_content_item', ['widget_id' => 'id']);
    }

    public function afterFind()
    {
        $this->items = $this->contentItems;
    }
}
