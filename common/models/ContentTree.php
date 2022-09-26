<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content_tree".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ContentTreeContent[] $contentTreeContents
 */
class ContentTree extends \yii\db\ActiveRecord
{
    const TYPE_NEWS = 'news';
    const TYPE_ARTICLES = 'articles';
    const TYPE_PAGES = 'pages';
    const TYPES = [self::TYPE_NEWS, self::TYPE_ARTICLES, self::TYPE_PAGES,];

    const TREE_TYPE_FOLDER = 'folder';
    const TREE_TYPE_CONTENT = 'content';

    const TYPE_NEWS_ID = -1;
    const TYPE_ARTICLES_ID = -2;
    const TYPE_PAGES_ID = -3;

    const TYPE_IDS = [self::TYPE_NEWS_ID => self::TYPE_NEWS, self::TYPE_PAGES_ID => self::TYPE_PAGES, self::TYPE_ARTICLES_ID => self::TYPE_ARTICLES,];

    const FOLDER_FONT = '{"font-weight":"bold"}';
    const NEW_FOLDER_NAME = 'Новая папка';

    /**
     * @param string $type
     *
     * @return string
     */
    public static function getTypeTitle(string $type) : string
    {
        $titles = self::getTypeTitles();

        return $titles[$type] ?? 'Не определен';
    }

    /**
     * @return array
     */
    public static function getTypeTitles() : array
    {
        return [
            self::TYPE_NEWS => 'Новости',
            self::TYPE_ARTICLES => 'Статьи',
            self::TYPE_PAGES => 'Страницы',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_tree';
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
            [['parent_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['parent_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['type', 'description'], 'string'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'type' => 'Тип контента',
            'name' => 'Название',
            'description' => 'Комментарий',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentTreeContents()
    {
        return $this->hasMany(ContentTreeContent::class, ['content_tree_id' => 'id',]);
    }

    public function delete()
    {


        return parent::delete();
    }
}
