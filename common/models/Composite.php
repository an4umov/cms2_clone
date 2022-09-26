<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "composite".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ContentItem[] $contentItems
 * @property string $description [varchar(255)]
 */
class Composite extends \yii\db\ActiveRecord
{
    const TYPE_TABS = 1;
    const TYPE_ACCORDION = 2;

    private static $types = [
        self::TYPE_TABS => 'Вкладки',
        self::TYPE_ACCORDION => 'Аккордеон',
    ];



    use HasImagesTrait;

    public $items;
    public $imagesCollection;

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @return array
     */
    public static function getTypes(): array
    {
        return self::$types;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getType($key)
    {
        return self::$types[$key];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'composite';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'created_at', 'updated_at'], 'default', 'value' => null],
            ['items', 'each', 'rule' => ['string']],
            [['type', 'created_at', 'updated_at'], 'integer'],
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
            'description' => 'Title',
            'type' => 'Type',
            'created_at' => 'Created At',
            'items' => 'Компоненты',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentItems()
    {
        return $this->hasMany(ContentItem::class, ['id' => 'content_item_id'])
            ->viaTable('composite_content_items', ['composite_id' => 'id']);
    }


    public function getImages()
    {
        return $this->hasMany(Image::class, ['id' => 'file_id'])
            ->viaTable('composite_file', ['composite_id' => 'id']);
    }

    public function afterFind()
    {
        $this->items = $this->contentItems;
    }
}
