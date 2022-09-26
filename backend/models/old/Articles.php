<?php

namespace backend\models\old;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string $url_key
 * @property int $deleted
 * @property int $cache
 * @property int $cache_time
 * @property string $create_time
 * @property string $last_change
 * @property string $title
 * @property string $description
 * @property string $announce
 * @property string $content
 * @property string $announce_image
 * @property int $order_num
 * @property int $show_on_the_main
 * @property int $main_category_id
 * @property string $video_announce
 * @property string $lr_articles
 * @property string $pageTitle
 * @property string $lr_checkResult
 *
 * @property ArticleToTag[] $articleToTags
 * @property Tags[] $tags
 * @property ArticlesDrafts[] $articlesDrafts
 */
class Articles extends \yii\db\ActiveRecord
{

    public $articleTags = [];
    public $image;

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'url_key',
            ],
        ];
    }


    public function afterFind()
    {
        $this->articleTags = ArrayHelper::map($this->tags, 'name', 'name');
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
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
            [['title', 'content'], 'required'],
            ['articleTags', 'each', 'rule' => ['string']],
            [['url_key', 'title', 'description', 'announce', 'content', 'announce_image', 'video_announce', 'lr_articles', 'pageTitle', 'lr_checkResult'], 'string'],
            [['deleted', 'cache', 'cache_time', 'order_num', 'show_on_the_main', 'main_category_id'], 'integer'],
            [['create_time', 'last_change'], 'safe'],
            [['image'], 'file'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_key' => 'Url',
            'deleted' => 'Удален',
            'cache' => 'Кеш',
            'cache_time' => 'Cache Time',
            'create_time' => 'Создан',
            'last_change' => 'Изменен',
            'title' => 'Заголовок',
            'description' => 'Описнаие',
            'announce' => 'Анонс',
            'content' => 'Контент',
            'announce_image' => 'Изображение анонса',
            'image' => 'Изменить изображение',
            'order_num' => 'Заказ',
            'show_on_the_main' => 'Показать на главной',
            'main_category_id' => 'Main Category ID',
            'video_announce' => 'Video Announce',
            'lr_articles' => 'Lr Articles',
            'pageTitle' => 'Заголовок страницы',
            'lr_checkResult' => 'Lr Check Result',
            'articleTags' => 'Теги'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleToTags()
    {
        return $this->hasMany(ArticleToTag::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])->viaTable('article_to_tag', ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticlesDrafts()
    {
        return $this->hasMany(ArticlesDrafts::className(), ['article_id' => 'id']);
    }
}
