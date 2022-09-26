<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "parser".
 *
 * @property int $id
 * @property string $type
 * @property string $article
 * @property string $article_our
 * @property string $article_1c
 * @property string $title
 * @property string $url
 * @property string $brand
 * @property string $country
 * @property string $description Описание товара короткое
 * @property string $description_ext Описание товара подробное
 * @property string $characteristics Дополнительное описание
 * @property string $links Ссылки на файлы инструкций
 * @property string $breadcrumbs
 * @property double $length длина, м
 * @property double $width ширина, м
 * @property double $height высота, м
 * @property double $weight вес, кг
 * @property int $created_at
 * @property int $updated_at
 */
class Parser extends \yii\db\ActiveRecord
{
    const TYPE_AUTOVENTURI = 'autoventuri';
    const TYPE_TRIABC = 'triabc';
    const TYPE_DALIAVTO = 'daliavto';
    const TYPE_RIVALAUTO = 'rivalauto';

    const TYPES = [self::TYPE_AUTOVENTURI, self::TYPE_TRIABC, self::TYPE_DALIAVTO, self::TYPE_RIVALAUTO,];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'url', 'description', 'description_ext', 'characteristics', 'links', 'breadcrumbs'], 'string'],
            [['article', 'article_our', 'article_1c', 'title', 'url'], 'required'],
            [['length', 'width', 'height', 'weight'], 'number'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            ['type', 'in', 'range' => self::TYPES,],
            [['article', 'article_our', 'article_1c', 'title', 'brand', 'country'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Поставщик',
            'article' => 'Артикул Поставщика',
            'article_our' => 'Артикул Наш',
            'article_1c' => 'Артикул занесенный в 1С',
            'title' => 'Наименование',
            'url' => 'Урл',
            'brand' => 'Бренд',
            'country' => 'Страна',
            'description' => 'Описание товара короткое',
            'description_ext' => 'Описание товара подробное',
            'characteristics' => 'Характеристики',
            'links' => 'Ссылки',
            'breadcrumbs' => 'Хлебные крошки',
            'length' => 'Длина, м',
            'width' => 'Ширина, м',
            'height' => 'Высота, м',
            'weight' => 'Вес, кг',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
}
