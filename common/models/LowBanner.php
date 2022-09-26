<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "low_banner".
 *
 * @property int $id
 * @property string $color
 * @property int $image
 * @property string $title
 * @property string $text
 * @property int $sort
 *
 * @property Image $background
 */
class LowBanner extends \yii\db\ActiveRecord
{
    public $upload_image;
    public $link = "#";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'low_banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'sort'], 'default', 'value' => null],
            [['image', 'sort'], 'integer'],
            [['color'], 'string', 'max' => 10],
            [['title', 'text'], 'string', 'max' => 255],
            [['image'], 'exist', 'skipOnError' => true, 'targetClass' => Image::class, 'targetAttribute' => ['image' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет подложки',
            'image' => 'Изображение',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'sort' => 'Сортировка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackground()
    {
        return $this->hasOne(Image::class, ['id' => 'image']);
    }
}
