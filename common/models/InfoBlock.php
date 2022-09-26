<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "info_block".
 *
 * @property int $id
 * @property string $color
 * @property int $type
 * @property int $sort
 *
 * @property ContentItem[] $contentItems
 * @property string $image [integer]
 * @property string $link [varchar(255)]
 */
class InfoBlock extends yii\db\ActiveRecord
{
    public $items;
    public $upload_image;

    const TYPE_WIDTH_4 = 4;
    const TYPE_WIDTH_2 = 2;
    const TYPE_WIDTH_2_2 = 3;

    static $types = [
        self::TYPE_WIDTH_2 => 'Модуль 2',
        self::TYPE_WIDTH_4 => 'Модуль 4',
        self::TYPE_WIDTH_2_2 => 'Модуль 2 по 2',
    ];

    /**
     * @return array
     */
    public static function getTypes()
    {
        return self::$types;
    }

    /**
     * @param $types
     * @return mixed
     */
    public static function getType($types)
    {
        return self::$types[$types];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'sort'], 'default', 'value' => null],
            [['type', 'sort', 'image'], 'integer'],
            [['link'], 'string'],
            ['items', 'each', 'rule' => ['string']],
            [['color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'type' => 'Type',
            'sort' => 'Sort',
            'image' => 'Фон',
            'link' => 'Урл для ссылки',
        ];
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public function getContentItems()
    {
        return $this->hasMany(ContentItem::class, ['id' => 'content_item_id'])->viaTable('info_block_content_item', ['info_block_id' => 'id'])->orderBy('sort');
    }

    public function afterFind()
    {
        $this->items = $this->contentItems;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackground()
    {
        return $this->hasOne(Image::class, [ 'id' => 'image' ]);
    }
}
