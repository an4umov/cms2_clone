<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tile".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ContentItem[] $contentItems
 */
class Tile extends \yii\db\ActiveRecord
{
    public $items;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
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
            'items' => 'Компоненты',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentItems()
    {
        return $this->hasMany(ContentItem::class, ['id' => 'content_item_id'])
            ->viaTable('tile_content_items', ['tile_id' => 'id']);
    }

    public function afterFind()
    {
        $this->items = $this->contentItems;
    }

}
