<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cross".
 *
 * @property int $id
 * @property int $line
 * @property string $superarticle
 * @property string $brand_code
 * @property string $brand_name
 * @property string $group_code
 * @property string $group_name
 * @property string $article
 * @property string $article_name
 * @property string $comment
 * @property int $created_at
 * @property int $updated_at
 */
class Cross extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cross';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['line', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['line', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['superarticle', 'brand_name', 'group_name', 'article_name'], 'string', 'max' => 150],
            [['brand_code', 'group_code'], 'string', 'max' => 11],
            [['article'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'line' => 'Line',
            'superarticle' => 'Суперартикул',
            'brand_code' => 'Код группы производителя',
            'brand_name' => 'Наименование группы производителя',
            'group_code' => 'Код группы замен',
            'group_name' => 'Наименование группы замен',
            'article' => 'Артикул',
            'article_name' => 'Наименование артикула',
            'comment' => 'Комментарий',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
