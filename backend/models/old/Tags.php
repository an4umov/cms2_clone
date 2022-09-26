<?php

namespace backend\models\old;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property int $id
 * @property string $name
 * @property int $count
 *
 * @property ArticleToTag[] $articleToTags
 * @property Articles[] $articles
 * @property TagsToMenuItems[] $tagsToMenuItems
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['count'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'count' => 'Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleToTags()
    {
        return $this->hasMany(ArticleToTag::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Articles::className(), ['id' => 'article_id'])->viaTable('article_to_tag', ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsToMenuItems()
    {
        return $this->hasMany(TagsToMenuItems::className(), ['tag_id' => 'id']);
    }
}
