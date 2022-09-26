<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "slider_tile".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SliderTileContentItem[] $sliderTileContentItems
 * @property ContentItem[] $contentItems
 */
class SliderTile extends \yii\db\ActiveRecord
{
    public $items;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider_tile';
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
            [['created_at', 'updated_at'], 'default', 'value' => null],
            ['items', 'each', 'rule' => ['string']],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentItems()
    {
        return $this->hasMany(ContentItem::class, ['id' => 'content_item_id'])->viaTable('slider_tile_content_item', ['slider_tile_id' => 'id'])->orderBy('sort');
    }

    public function afterFind()
    {
        $this->items = $this->contentItems;
    }
}
