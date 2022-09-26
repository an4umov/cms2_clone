<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shop_banner".
 *
 * @property int $id
 * @property string $color
 * @property int $image
 * @property string $title
 * @property string $description
 * @property int $sort
 *
 * @property int $type [smallint]
 */
class ShopBanner extends \yii\db\ActiveRecord
{

    public $upload_image;

    const TYPE_WIDTH_4 = 4;
    const TYPE_WIDTH_2 = 2;

    static $types = [
        self::TYPE_WIDTH_2 => 'Модуль 2',
        self::TYPE_WIDTH_4 => 'Модуль 4',
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
        return 'shop_banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'sort'], 'default', 'value' => null],
            [['image', 'sort', 'type'], 'integer'],
            [['color'], 'string', 'max' => 10],
            [['title', 'description'], 'string', 'max' => 255],
            [['image'], 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['image' => 'id']],
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
            'description' => 'Текст',
            'sort' => 'Сортировка',
            'type' => 'Тип баннера',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackground()
    {
        return $this->hasOne(Image::class, ['id' => 'image']);
    }

    public function afterFind()
    {
        if (empty($this->type)) {
            $this->type = 4;
        }
    }
}
