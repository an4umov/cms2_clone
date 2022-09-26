<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "parser_autoventuri".
 *
 * @property int $id
 * @property string $article
 * @property string $article_our
 * @property string $brand
 * @property string $title
 * @property string $description
 * @property string $characteristics
 * @property string $breadcrumbs
 * @property string $url
 * @property int $created_at
 * @property int $updated_at
 */
class ParserAutoventuri extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_autoventuri';
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
            [['article', 'article_our', 'title', 'url'], 'required'],
            [['description', 'characteristics', 'breadcrumbs', 'url'], 'string'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['article', 'article_our', 'brand', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article' => 'Артикул Поставщика',
            'article_our' => 'Артикул Наш',
            'brand' => 'Бренд',
            'title' => 'Наименование',
            'description' => 'Описание',
            'characteristics' => 'Дополнительные характеристики',
            'breadcrumbs' => 'Хлебные крошки',
            'url' => 'Урл',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
