<?php

namespace common\models;

/**
 * This is the model class for table "article_recomend".
 *
 * @property int $id
 * @property string $number
 * @property string $recomendation
 * @property string $articles
 * @property string $comment
 * @property string $color
 * @property int $created_at
 * @property int $updated_at
 */
class ArticleRecomend extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_recomend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'articles'], 'required'],
            [['recomendation', 'comment'], 'string'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['number'], 'string', 'max' => 64],
            [['articles'], 'string', 'max' => 128],
            [['color'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Артикул',
            'recomendation' => 'Текст (флаг) рекомендации',
            'articles' => 'Список рекомендуемых артикулов', // через запятую
            'comment' => 'Комментарий',
            'color' => 'Цвет',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
