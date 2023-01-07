<?php

namespace common\models;

use backend\components\helpers\IconHelper;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $page_index_type
 * @property string $alias
 * @property string $article_numbers
 * @property string $title
 * @property boolean $is_index_page
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property int $views
 *
 * @property ContentBlock[] $contentBlocks
 * @property ContentFilter[] $contentFilters
 * @property ContentFilterPage[] $contentFilterPages
 * @property ContentCustomTag[] $contentCustomTags
 * @property CustomTag[] $customTags
 * @property Block[] $blocks
 */
class Content extends \yii\db\ActiveRecord
{
    const ALIAS_PATTERN = '/^[\w\.\-]+$/';
    const SORT_KEY = 'sort';
    const ARTICLE_NUMBERS_SEPARATOR = ',';

    const TYPE_PAGE = 'page';
    const TYPE_ARTICLE = 'article';
    const TYPE_NEWS = 'news';
    const TYPE_SETTING = 'setting';

    const TYPES = [
        self::TYPE_PAGE,
        self::TYPE_ARTICLE,
        self::TYPE_NEWS,
        self::TYPE_SETTING,
    ];

    const PAGE_INDEX_TYPE_DEFAULT = 'default';
    const PAGE_INDEX_TYPE_NEWS = 'news';
    const PAGE_INDEX_TYPE_PAGES = 'pages';
    const PAGE_INDEX_TYPE_ARTICLES = 'articles';

    const PAGE_INDEX_TYPES = [
        self::PAGE_INDEX_TYPE_DEFAULT,
        self::PAGE_INDEX_TYPE_NEWS,
        self::PAGE_INDEX_TYPE_PAGES,
        self::PAGE_INDEX_TYPE_ARTICLES,
    ];

    const SETTING_HEADER_ID = 12;
    const SETTING_FOOTER_ID = 13;

    public $content_blocks_list;
    public $filters;
    public $tags;
    private $_types;
    private $_pageIndexTypes;
    private $_manyTypes;
    private $_typeToTypes;

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_PAGE => 'Страница',
            self::TYPE_ARTICLE => 'Статья',
            self::TYPE_NEWS => 'Новость',
        ];
        $this->_pageIndexTypes = [
            self::PAGE_INDEX_TYPE_DEFAULT => 'Обычная',
            self::PAGE_INDEX_TYPE_NEWS => 'Индексная для новостей',
            self::PAGE_INDEX_TYPE_PAGES => 'Индексная для страниц',
            self::PAGE_INDEX_TYPE_ARTICLES => 'Индексная для статей',
        ];
        $this->_manyTypes = [
            self::TYPE_PAGE => 'Страницы',
            self::TYPE_ARTICLE => 'Статьи',
            self::TYPE_NEWS => 'Новости',
        ];
        $this->_typeToTypes = [
            self::TYPE_PAGE => self::TYPE_PAGE.'s',
            self::TYPE_ARTICLE => self::TYPE_ARTICLE.'s',
            self::TYPE_NEWS => self::TYPE_NEWS,
        ];
    }

    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        return $this->_types;
    }

    /**
     * @return array
     */
    public function getPageIndexTypeOptions() : array
    {
        $types = $this->_pageIndexTypes;
        $rows = Content::find()->select(['id', 'page_index_type',])->where(['type' => self::TYPE_PAGE,])->asArray()->all();

        foreach ($rows as $row) {
            if ($row['page_index_type'] != self::PAGE_INDEX_TYPE_DEFAULT && isset($types[$row['page_index_type']]) && $this->id != $row['id']) {
                unset($types[$row['page_index_type']]);
            }
        }

        return $types;
    }

    /**
     * @return array
     */
    public function getManyTypeOptions() : array
    {
        return $this->_manyTypes;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeIcon(string $type) : string
    {
        return $type === self::TYPE_PAGE ? IconHelper::ICON_PAGES : ($type === self::TYPE_ARTICLE ? IconHelper::ICON_ARTICLES : IconHelper::ICON_NEWS);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        $this->_types[self::TYPE_SETTING] = 'Настройка';

        return $this->_types[$type];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getPageIndexTypeTitle(string $type) : string
    {
        return $this->_pageIndexTypes[$type];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getManyTypeTitle(string $type) : string
    {
        return $this->_manyTypes[$type];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeToTypesTitle(string $type) : string
    {
        return $this->_typeToTypes[$type];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
//            [
//                'class' => SluggableBehavior::class,
//                'attribute' => 'name',
//                'slugAttribute' => 'alias',
//                'immutable' => false,
//                'ensureUnique' => false,
//            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type', 'title', 'page_index_type',], 'string'],
            ['type', 'in', 'range' => self::TYPES,],
            [['created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'deleted_at', 'views',], 'integer'],
            [['content_blocks_list',], 'safe',],
            [['is_index_page',], 'boolean'],
            [['name', 'alias', 'title',], 'string', 'max' => 255],
            [['name', 'alias'], 'trim',],
            ['alias', 'unique', 'skipOnEmpty' => true, 'targetAttribute' => ['type', 'alias'], 'filter' => ['<>', 'alias', '',],],
            ['alias', 'match', 'pattern' => self::ALIAS_PATTERN, 'message' => 'Допустимы только англ. буквы, цифры, тире и подчеркивание'],
            [['alias',], 'default'],
            [['filters', 'tags', 'article_numbers',], 'safe'],
            [['is_index_page',], 'default', 'value' => false,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'type' => 'Тип',
            'page_index_type' => 'Тип для страницы',
            'alias' => 'Урл',
            'is_index_page' => 'Главная страница',
            'title' => 'Заглавие контента',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'deleted_at' => 'Удалено',
            'views' => 'Просмотров',
            'article_numbers' => 'Ссылка на артикулы, через запятую',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getContentBlocks()
    {
        return $this->hasMany(ContentBlock::class, ['content_id' => 'id',])->orderBy([ContentBlock::tableName().'.sort' => SORT_ASC,]);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getContentFilters()
    {
        return $this->hasMany(ContentFilter::class, ['content_id' => 'id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getContentFilterPages()
    {
        return $this->hasMany(ContentFilterPage::class, ['content_id' => 'id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getContentCustomTags()
    {
        return $this->hasMany(ContentCustomTag::class, ['content_id' => 'id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomTags()
    {
        return $this->hasMany(CustomTag::class, ['id' => 'custom_tag_id',])
            ->via('contentCustomTags');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlocks()
    {
        return $this->hasMany(Block::class, ['id' => 'block_id',])
            ->via('contentBlocks');
    }


    /**
     * @return Block[]
     */
    public function getBlocksList() : array
    {
        return Block::find()
            ->select([
                Block::tableName().'.id',
                Block::tableName().'.name',
                Block::tableName().'.description',
                Block::tableName().'.type',
                Block::tableName().'.global_type',
                ContentBlock::tableName().'.id AS content_block_id',
                ContentBlockField::tableName().'.data',
            ])
            ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.Block::tableName().'.id')
            ->leftJoin(ContentBlockField::tableName(), ContentBlock::tableName().'.id = '.ContentBlockField::tableName().'.content_block_id')
            ->where([
                ContentBlock::tableName().'.content_id' => $this->id,
                Block::tableName().'.deleted_at' => null,
            ])
            ->asArray(false)
            ->orderBy([ContentBlock::tableName().'.sort' => SORT_ASC,])
            ->indexBy('id')
            ->all();
    }

    /**
     * @return Block
     */
    public function getNewsAnonsBlock()
    {
        return Block::find()
            ->select([
                Block::tableName().'.id',
                Block::tableName().'.name',
                Block::tableName().'.description',
                Block::tableName().'.type',
                ContentBlock::tableName().'.id AS content_block_id',
                ContentBlockField::tableName().'.data',
            ])
            ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.Block::tableName().'.id')
            ->leftJoin(ContentBlockField::tableName(), ContentBlock::tableName().'.id = '.ContentBlockField::tableName().'.content_block_id')
            ->where([
                ContentBlock::tableName().'.content_id' => $this->id,
                Block::tableName().'.deleted_at' => null,
                Block::tableName().'.global_type' => Block::GLOBAL_TYPE_TEXT_NEWS_ANONS,
            ])
            ->asArray(false)
            ->indexBy('id')
            ->one();
    }

    /**
     * @return array
     */
    public function getBlocksData() : array
    {
        $blockQuery = Block::find()
            ->select([
                Block::tableName().'.id',
                Block::tableName().'.name',
                Block::tableName().'.description',
                Block::tableName().'.type',
                Block::tableName().'.global_type',
                ContentBlockField::tableName().'.data',
                ContentBlock::tableName().'.id AS content_block_id',
                ContentBlock::tableName().'.type AS content_block_type',
                ContentBlock::tableName().'.sort AS content_block_sort',
                ContentBlock::tableName().'.is_active AS content_block_is_active',
                new Expression("NULL AS color"),
                new Expression("NULL AS color_bg"),
                new Expression("NULL AS emails"),
                new Expression("NULL AS result"),
            ])
            ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.Block::tableName().'.id')
            ->leftJoin(ContentBlockField::tableName(), ContentBlock::tableName().'.id = '.ContentBlockField::tableName().'.content_block_id')
            ->where([
                ContentBlock::tableName().'.type' => ContentBlock::TYPE_BLOCK,
                ContentBlock::tableName().'.content_id' => $this->id,
                Block::tableName().'.deleted_at' => null,
            ])
            ->asArray()
            ->indexBy('content_block_id');

        $blockReadyQuery = BlockReady::find()
            ->select([
                BlockReady::tableName().'.id',
                BlockReady::tableName().'.name',
                BlockReady::tableName().'.description',
                new Expression("'".Block::TYPE_TEXT."' AS type"),
                BlockReady::tableName().'.global_type',
                BlockReady::tableName().'.data',
                ContentBlock::tableName().'.id AS content_block_id',
                ContentBlock::tableName().'.type AS content_block_type',
                ContentBlock::tableName().'.sort AS content_block_sort',
                ContentBlock::tableName().'.is_active AS content_block_is_active',
                new Expression("NULL AS color"),
                new Expression("NULL AS color_bg"),
                new Expression("NULL AS emails"),
                new Expression("NULL AS result"),
            ])
            ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.BlockReady::tableName().'.id')
            ->where([
                ContentBlock::tableName().'.type' => ContentBlock::TYPE_BLOCK_READY,
                ContentBlock::tableName().'.content_id' => $this->id,
                BlockReady::tableName().'.is_active' => true,
            ])
            ->asArray()
            ->indexBy('content_block_id');

        $formQuery = Form::find()
            ->select([
                Form::tableName().'.id',
                Form::tableName().'.name',
                Form::tableName().'.description',
                new Expression("'".Block::TYPE_FORM."' AS type"),
                new Expression("NULL AS global_type"),
                new Expression("NULL AS data"),
                ContentBlock::tableName().'.id AS content_block_id',
                ContentBlock::tableName().'.type AS content_block_type',
                ContentBlock::tableName().'.sort AS content_block_sort',
                ContentBlock::tableName().'.is_active AS content_block_is_active',
                Form::tableName().'.color',
                Form::tableName().'.color_bg',
                Form::tableName().'.emails',
                Form::tableName().'.result',
            ])
            ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.Form::tableName().'.id')
            ->where([
                ContentBlock::tableName().'.type' => ContentBlock::TYPE_FORM,
                ContentBlock::tableName().'.content_id' => $this->id,
                Form::tableName().'.deleted_at' => null,
            ])
            ->asArray()
            ->indexBy('content_block_id');

        $query = new yii\db\Query();
        $query->select('*')->from(['u' => $blockQuery->union($blockReadyQuery, true)->union($formQuery, true),])->orderBy(['content_block_sort' => SORT_ASC,]);
        $query->indexBy('content_block_id');

        return $query->all();
    }

    /**
     * @return int
     */
    public function getAllBlocksCount() : int
    {
        $blockQuery = Block::find()
            ->select([
                Block::tableName().'.id',
            ])
            ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.Block::tableName().'.id')
            ->where([
                ContentBlock::tableName().'.type' => ContentBlock::TYPE_BLOCK,
                ContentBlock::tableName().'.content_id' => $this->id,
                Block::tableName().'.deleted_at' => null,
            ])
            ->asArray()
            ->indexBy('content_block_id');

        $blockReadyQuery = BlockReady::find()
            ->select([
                BlockReady::tableName().'.id',
            ])
            ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.BlockReady::tableName().'.id')
            ->where([
                ContentBlock::tableName().'.type' => ContentBlock::TYPE_BLOCK_READY,
                ContentBlock::tableName().'.content_id' => $this->id,
                BlockReady::tableName().'.is_active' => true,
            ])
            ->asArray()
            ->indexBy('content_block_id');

        $query = new yii\db\Query();
        $query->select('*')->from(['u' => $blockQuery->union($blockReadyQuery, true),]);

        return $query->count();
    }

    /**
     * @param array $blockData
     * @param int   $blockID
     *
     * @return array
     */
    public function getBlockFromBlockData(array $blockData, int $blockID) : array
    {
        $block = [];

        foreach ($blockData as $data) {
            if ($data['id'] == $blockID) {
                $block = $data;
                break;
            }
        }

        return $block;
    }

    /**
     * @param array $blockData
     * @param int   $blockID
     *
     * @return array
     */
    public function getBlockFromBlockDataByContentBlock(array $blockData, int $contentBlockID) : array
    {
        $block = [];

        foreach ($blockData as $data) {
            if ($data['content_block_id'] == $contentBlockID) {
                $block = $data;
                break;
            }
        }

        return $block;
    }

    /**
     * @param array $blockData
     * @param int   $blockID
     *
     * @return array
     */
    public function getBlockData(array $blockData, int $blockID) : array
    {
        $block = [];

        foreach ($blockData as $data) {
            if ($data['id'] == $blockID) {
                $block = $data;
                break;
            }
        }

        return $block;
    }

    /**
     * @return int
     */
    public function getBlocksCount() : int
    {
        return $this->getBlocks()->count();
    }

    /**
     * @return bool|false|int
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        $this->deleted_at = time();

        $deleted = $this->save(false);

        return $deleted;
    }

    public function deletePermanently()
    {
        $this->delete();
    }

    public function beforeSave($insert)
    {
        // Сохранение поля "Ссылка на Артикул"
        if (in_array($this->type, [self::TYPE_ARTICLE, self::TYPE_NEWS,])) {
            if (!empty($this->article_numbers) && is_array($this->article_numbers)) {
                $this->article_numbers = implode(self::ARTICLE_NUMBERS_SEPARATOR, $this->article_numbers);
            } else {
                $this->article_numbers = null;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function getArticleNumbers() : array
    {
        return !empty($this->article_numbers) ? explode(self::ARTICLE_NUMBERS_SEPARATOR, $this->article_numbers) : [];
    }

    /**
     * @return array
     */
    public function getCarModelOptions() : array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getCarModelFilterData() : array
    {
        return ContentFilterCarModel::find()->select('car_model_id')->where(['content_id' => $this->id,])->column();
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $isSaved = parent::save($runValidation, $attributeNames);

        if ($isSaved && !empty($this->content_blocks_list) && is_array($this->content_blocks_list)) { // //Content[content_blocks_list][103][blocks_list][19][fields][233]
            $contentBlocks = $this->getContentBlocks()->with('contentBlockField')->all();

            foreach ($this->content_blocks_list as $contentBlockID => $contentBlockData) {
                foreach ($contentBlockData['blocks_list'] as $blockID => $blocksListData) {
                    $data = [];

                    if (!empty($blocksListData['sort']) || isset($blocksListData['is_active'])) {
                        if ($contentBlock = ContentBlock::findOne(['id' => $contentBlockID,])) {
                            if (!empty($blocksListData['sort'])) {
                                $contentBlock->sort = (int)$blocksListData['sort'];
                            }
                            $contentBlock->is_active = (boolean)$blocksListData['is_active'];
                            $contentBlock->save();
                        }
                    }

                    if (!empty($blocksListData['fields'])) {
                        foreach ($blocksListData['fields'] as $fieldID => $fieldData) { //[264] => [list][1][44]   [348] => [g_color][left]
                            if (is_array($fieldData)) {
                                if (!empty($fieldData[BlockField::TYPE_LIST])) { //список полей
                                    $index = 0;
                                    foreach ($fieldData[BlockField::TYPE_LIST] as $fieldListData) {
                                        foreach ($fieldListData as $fieldListID => $value) {
                                            $data[$fieldID][$index][$fieldListID] = $value;
                                        }
                                        $index++;
                                    }
                                } elseif (!empty($fieldData[BlockField::TYPE_GRADIENT_COLOR])) { //град. цвет
                                    $data[$fieldID][BlockField::GRADIENT_COLOR_LEFT] = !empty($fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_LEFT]) ? $fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_LEFT] : '';
                                    $data[$fieldID][BlockField::GRADIENT_COLOR_CENTER] = !empty($fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_CENTER]) ? $fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_CENTER] : '';
                                    $data[$fieldID][BlockField::GRADIENT_COLOR_RIGHT] = !empty($fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_RIGHT]) ? $fieldData[BlockField::TYPE_GRADIENT_COLOR][BlockField::GRADIENT_COLOR_RIGHT] : '';
                                } elseif (!empty($fieldData[BlockField::TYPE_STRUCTURE_ID])) { //структуры департаментов
                                    if (!empty($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_DEPARTMENT])) {
                                        $data[$fieldID][ContentFilter::TYPE_DEPARTMENT] = [];
                                        foreach ($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_DEPARTMENT] as $id => $value) {
                                            if (!empty($value)) {
                                                $data[$fieldID][ContentFilter::TYPE_DEPARTMENT][] = $id;
                                            }
                                        }
                                    }
                                    if (!empty($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_MENU])) {
                                        $data[$fieldID][ContentFilter::TYPE_MENU] = [];
                                        foreach ($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_MENU] as $id => $value) {
                                            if (!empty($value)) {
                                                $data[$fieldID][ContentFilter::TYPE_MENU][] = $id;
                                            }
                                        }
                                    }
                                    if (!empty($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_TAG])) {
                                        $data[$fieldID][ContentFilter::TYPE_TAG] = [];
                                        foreach ($fieldData[BlockField::TYPE_STRUCTURE_ID][ContentFilter::TYPE_TAG] as $id => $value) {
                                            if (!empty($value)) {
                                                $data[$fieldID][ContentFilter::TYPE_TAG][] = $id;
                                            }
                                        }
                                    }
                                }
                            } else { //не массив
                                $data[$fieldID] = $fieldData;
                            }
                        }
                    }

                    /**
                     * @var $contentBlock ContentBlock
                     */
                    foreach ($contentBlocks as $contentBlock) {
                        if ($contentBlock->id == $contentBlockID) {
                            $contentBlockField = $contentBlock->contentBlockField;

                            if (empty($contentBlockField)) {
                                $contentBlockField = new ContentBlockField();
                                $contentBlockField->content_block_id = $contentBlock->id;
                            }
                            $contentBlockField->setData($data);
                            $contentBlockField->save();

                            break;
                        }
                    }
                }
            }
        }

        if ($isSaved/* && $this->type !== self::TYPE_PAGE*/) {
            ContentFilter::deleteAll(['content_id' => $this->id,]);
            ContentFilterPage::deleteAll(['content_id' => $this->id,]);
            ContentFilterCarModel::deleteAll(['content_id' => $this->id,]);

            if (!empty($this->filters) && is_array($this->filters)) {
                foreach ([ContentFilter::TYPE_DEPARTMENT, ContentFilter::TYPE_MENU, ContentFilter::TYPE_TAG,] as $filterType) {
                    if (!empty($this->filters[$filterType])) {
                        foreach ($this->filters[$filterType] as $id => $value) {
                            if ($value) {
                                $model = new ContentFilter();
                                $model->content_id = $this->id;
                                $model->list_id = $id;
                                $model->type = $filterType;
                                $model->save();
                            }
                        }
                    }
                }

                if (!empty($this->filters[ContentFilter::TYPE_PAGES])) {
                    foreach (ContentFilterPage::TYPES as $type) {
                        if (!empty($this->filters[ContentFilter::TYPE_PAGES][$type])) {
                            foreach ($this->filters[ContentFilter::TYPE_PAGES][$type] as $id => $value) {
                                if ($value) {
                                    $model = new ContentFilterPage();
                                    $model->content_id = $this->id;
                                    $model->department_content_id = $id;
                                    $model->type = $type;
                                    $model->save();
                                }
                            }
                        }
                    }
                }

                if (!empty($this->filters[ContentFilter::TYPE_MODEL])) {
                    foreach ($this->filters[ContentFilter::TYPE_MODEL] as $id) {
                        $model = new ContentFilterCarModel();
                        $model->content_id = $this->id;
                        $model->car_model_id = $id;
                        $model->save();
                    }
                }
            }

            $contentTags = $this->getContentCustomTags()->all();
            if ($contentTags) {
                foreach ($contentTags as $contentTag) {
                    $contentTag->delete();
                }
            }

            if (!empty($this->tags) && is_array($this->tags)) {
                foreach ($this->tags as $id => $value) {
                    if ($value) {
                        $model = new ContentCustomTag();
                        $model->content_id = $this->id;
                        $model->custom_tag_id = $id;
                        $model->save();
                    }
                }
            }
        }

        return $isSaved;
    }

    /**
     * @return string
     */
    public function getPageClass() : string
    {
        $class = 'default';

        if ($this->type === self::TYPE_PAGE) {
            if ($this->is_index_page) {
                $class = 'success';
            } elseif (in_array($this->page_index_type, [Content::PAGE_INDEX_TYPE_ARTICLES, Content::PAGE_INDEX_TYPE_NEWS, Content::PAGE_INDEX_TYPE_PAGES,])) {
                $class = 'info';
            }
        }

        return  $class;
    }

    /**
     * @param Department|null $department
     *
     * @return string
     */
    public function getContentUrl(Department $department = null) : string
    {
        return '/'.$this->getTypeToTypesTitle($this->type).'/'.($this->alias ?: $this->id) . ($department ? '?shop='.$department->url : '');
    }

    /**
     * @return bool
     */
    public function incViewsCount() : bool
    {
        return $this->updateCounters(['views' => 1,]);
    }

    /**
     * @return string
     */
    public function isLandingPageContent() : string
    {
        $isFound = false;

        if ($this->type === self::TYPE_PAGE) {
            $departmentId = Department::find()->select(['id',])->where(['landing_page_id' => $this->id,])->scalar();
            if (!$departmentId) {
                $departmentMenuId = DepartmentMenu::find()->select(['id',])->where(['landing_page_id' => $this->id,])->scalar();
                if (!$departmentMenuId) {
                    $departmentMenuTagId = DepartmentMenuTag::find()->select(['id',])->where(['landing_page_id' => $this->id,])->scalar();
                    if ($departmentMenuTagId) {
                        $isFound = true;
                    }
                } else {
                    $isFound = true;
                }
            } else {
                $isFound = true;
            }

            if (!$isFound) {
                $greenMenuId = GreenMenu::find()->select(['id',])->where(['landing_page_id' => $this->id,])->scalar();
                if ($greenMenuId) {
                    $isFound = true;
                }
            }
        }

        return $isFound ? ' '.Html::tag('span', '', ['class' => \backend\components\helpers\IconHelper::ICON_STRUCTURES, 'title' => 'Установлена как посадочная страница',]) : '';
    }
}
