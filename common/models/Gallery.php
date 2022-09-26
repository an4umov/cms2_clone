<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property array $options
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ContentItem[] $contentItems
 *
 * @property GalleriesFiles[] $images
 */
class Gallery extends \yii\db\ActiveRecord
{
    use HasImagesTrait;

    public $items;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
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
            [['options'], 'safe'],
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
            'title' => 'Заголовок',
            'description' => 'Описание',
            'options' => 'Опции',
            'items' => 'Компоненты',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['id' => 'file_id'])
            ->viaTable(GalleriesFiles::tableName(), ['gallery_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentItems()
    {
        return $this->hasMany(ContentItem::class, ['id' => 'content_item_id'])
            ->viaTable('gallery_content_item', ['gallery_id' => 'id']);
    }

    public function afterFind()
    {
        $this->items = $this->contentItems;
    }
}