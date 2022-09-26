<?php

namespace common\models;

use backend\components\helpers\IconHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "block".
 *
 * @property int            $id
 * @property string         $name
 * @property string         $description
 * @property string         $type
 * @property string         $global_type
 * @property int            $created_at
 * @property int            $updated_at
 * @property int            $deleted_at
 *
 * @property BlockField[]   $blockFields
 * @property ContentBlock[] $contentBlocks
 * @property Content[]      $contents
 */
class Block extends BlockCommon
{
    const FIELD_IMAGE = 'image';
    const FIELD_BACKGROUND_IMAGE = 'bg_image';
    const FIELD_BACKGROUND_COLOR = 'bg_color';
    const FIELD_HEADER = 'header';
    const FIELD_TEXT = 'text';
    const FIELD_TEXT_LEFT = 'text_left';
    const FIELD_TEXT_RIGHT = 'text_right';
    const FIELD_IMAGE_LEFT = 'image_left';
    const FIELD_IMAGE_RIGHT = 'image_right';
    const FIELD_DATE = 'date';
    const FIELD_IS_ANSWER = 'is_answer';
    const FIELD_TYPE = 'type';
    const FIELD_TYPE_VALUE_PIC_PIC = 'картинка-картинка';
    const FIELD_TYPE_VALUE_TEXT_PIC = 'слева текст-справа картинка';
    const FIELD_TYPE_VALUE_TEXT_TEXT = 'текст-текст';
    const FIELD_TYPE_VALUE_PIC_TEXT = 'слева картинка-справа текст';

    const TYPE_BLOCK = 'block';
    const TYPE_GALLERY = 'gallery';
    const TYPE_TEXT = 'text';
    const TYPE_BANNER = 'banner';
    const TYPE_SLIDER = 'slider';
    const TYPE_FILTER = 'filter';
    const TYPE_SETTING = 'setting';
    const TYPE_AGGREGATOR = 'aggregator';
    const TYPE_BLOCK_READY = 'block_ready';
    const TYPE_FORM = 'form';

    const GLOBAL_TYPE_GALLERY_IMAGE = 'gallery_image';
    const GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140 = 'gallery_image_slider_1440';
    const GLOBAL_TYPE_GALLERY_LIST = 'gallery_list';
    const GLOBAL_TYPE_GALLERY_TV = 'gallery_tv';
    const GLOBAL_TYPE_GALLERY_YOUTUBE = 'gallery_youtube';
    const GLOBAL_TYPE_TEXT_HEADER = 'text_header';
    const GLOBAL_TYPE_TEXT_NEWS_ANONS = 'text_news_anons';
    const GLOBAL_TYPE_TEXT_TWO_SQUARES = 'text_news_text';
    const GLOBAL_TYPE_TEXT_850 = 'text_800';
    const GLOBAL_TYPE_TEXT_EMPTY_STRING = 'text_empty_string';
    const GLOBAL_TYPE_BANNER_HOMEPAGE_1_4 = 'banner_homepage_1_4';
    const GLOBAL_TYPE_BANNER_HOMEPAGE_2_4 = 'banner_homepage_2_4';
    const GLOBAL_TYPE_BANNER_HOMEPAGE_6_6 = 'banner_homepage_6_6';
    const GLOBAL_TYPE_BANNER_HOMEPAGE_8_8 = 'banner_homepage_8_8';
    const GLOBAL_TYPE_BANNER_NARROW = 'banner_narrow';
    const GLOBAL_TYPE_BANNER_AGREEMENT = 'banner_agreement';
    const GLOBAL_TYPE_SLIDER_CAROUSEL = 'slider_carousel';
    const GLOBAL_TYPE_AGGREGATOR_NEWS_TILE = 'aggregator_news_tile'; // Плитка новостей
    const GLOBAL_TYPE_AGGREGATOR_NEWS_TAPE = 'aggregator_news_tape'; // Лента новостей
    const GLOBAL_TYPE_AGGREGATOR_ARTICLES = 'aggregator_articles';
    const GLOBAL_TYPE_AGGREGATOR_SPECIAL_OFFER = 'special_offer';
    const GLOBAL_TYPE_FORM_DIALOG_LINK = 'form_dialog_link';
    const GLOBAL_TYPE_GALLERY_TILE_3 = 'gallery_tile_3';
    const GLOBAL_TYPE_GALLERY_TILE_6 = 'gallery_tile_6';
    const GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_1 = 'banner_homepage_department_1';
    const GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_2 = 'banner_homepage_department_2';
    const GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_3 = 'banner_homepage_department_3';
    const GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_6 = 'banner_homepage_department_6';

    const TYPES = [
        self::TYPE_GALLERY,
        self::TYPE_TEXT,
        self::TYPE_BANNER,
        self::TYPE_SLIDER,
        self::TYPE_FILTER,
        self::TYPE_SETTING,
        self::TYPE_BLOCK_READY,
        self::TYPE_AGGREGATOR,
        self::TYPE_FORM,
    ];

    const GLOBAL_TYPES = [
        self::GLOBAL_TYPE_GALLERY_IMAGE,
        self::GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140,
        self::GLOBAL_TYPE_GALLERY_LIST,
        self::GLOBAL_TYPE_GALLERY_TV,
        self::GLOBAL_TYPE_GALLERY_YOUTUBE,
        self::GLOBAL_TYPE_TEXT_HEADER,
        self::GLOBAL_TYPE_TEXT_NEWS_ANONS,
        self::GLOBAL_TYPE_TEXT_TWO_SQUARES,
        self::GLOBAL_TYPE_TEXT_850,
        self::GLOBAL_TYPE_TEXT_EMPTY_STRING,
        self::GLOBAL_TYPE_BANNER_HOMEPAGE_1_4,
        self::GLOBAL_TYPE_BANNER_HOMEPAGE_2_4,
        self::GLOBAL_TYPE_BANNER_HOMEPAGE_6_6,
        self::GLOBAL_TYPE_BANNER_HOMEPAGE_8_8,
        self::GLOBAL_TYPE_BANNER_NARROW,
        self::GLOBAL_TYPE_BANNER_AGREEMENT,
        self::GLOBAL_TYPE_SLIDER_CAROUSEL,
        self::GLOBAL_TYPE_AGGREGATOR_NEWS_TILE,
        self::GLOBAL_TYPE_AGGREGATOR_NEWS_TAPE,
        self::GLOBAL_TYPE_AGGREGATOR_ARTICLES,
        self::GLOBAL_TYPE_AGGREGATOR_SPECIAL_OFFER,
        self::GLOBAL_TYPE_FORM_DIALOG_LINK,
        self::GLOBAL_TYPE_GALLERY_TILE_3,
        self::GLOBAL_TYPE_GALLERY_TILE_6,
        self::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_1,
        self::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_2,
        self::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_3,
        self::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_6,
    ];

    private $_types;
    private $_globalTypes;
    public $sort_list;
    public $content_block_id;
    public $content_block_type;
    public $content_block_sort;
    public $data;

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_GALLERY => 'Картинки и галереи',
            self::TYPE_TEXT => 'Тексты и комбо',
            self::TYPE_BANNER => 'Баннер магазина',
            self::TYPE_SLIDER => 'Баннеры и слайдеры',
            self::TYPE_FILTER => 'Баннер модальный',
            self::TYPE_AGGREGATOR => 'Агрегаторы',
        ];

        $this->_globalTypes = [
            self::GLOBAL_TYPE_GALLERY_IMAGE => 'Картинка обычная',
            self::GLOBAL_TYPE_GALLERY_IMAGE_SLIDER_1140 => 'Картинка - слайдер 1140px',
            self::GLOBAL_TYPE_GALLERY_LIST => 'Галерея',
            self::GLOBAL_TYPE_GALLERY_TV => 'Телевизор',
            self::GLOBAL_TYPE_GALLERY_YOUTUBE => 'Картинка Youtube',
            self::GLOBAL_TYPE_TEXT_HEADER => 'Заголовок',
            self::GLOBAL_TYPE_TEXT_NEWS_ANONS => 'Анонс новости',
            self::GLOBAL_TYPE_TEXT_TWO_SQUARES => 'Комбинированный блок "2 квадрата"',
            self::GLOBAL_TYPE_TEXT_850 => 'Тест простой 850 х 18',
            self::GLOBAL_TYPE_TEXT_EMPTY_STRING => 'Пустая строка',
            self::GLOBAL_TYPE_BANNER_HOMEPAGE_1_4 => 'Баннер на главную модуль 1х4',
            self::GLOBAL_TYPE_BANNER_HOMEPAGE_2_4 => 'Баннер на главную модуль 2х4',
            self::GLOBAL_TYPE_BANNER_HOMEPAGE_6_6 => 'Баннер на главную модуль 6х6',
            self::GLOBAL_TYPE_BANNER_HOMEPAGE_8_8 => 'Баннер на главную модуль 8х8',
            self::GLOBAL_TYPE_BANNER_NARROW => 'Баннер узкий',
            self::GLOBAL_TYPE_BANNER_AGREEMENT => 'Баннер Согласен с условиями',
            self::GLOBAL_TYPE_SLIDER_CAROUSEL => 'Слайдер Карусель',
            self::GLOBAL_TYPE_AGGREGATOR_NEWS_TILE => 'Плитка новостей',
            self::GLOBAL_TYPE_AGGREGATOR_NEWS_TAPE => 'Лента новостей',
            self::GLOBAL_TYPE_AGGREGATOR_SPECIAL_OFFER => 'Спецпредложение товаров',
            self::GLOBAL_TYPE_AGGREGATOR_ARTICLES => 'Агрегатор статей',
            self::GLOBAL_TYPE_FORM_DIALOG_LINK => 'Модальное окно формы',
            self::GLOBAL_TYPE_GALLERY_TILE_3 => 'Галерея Плитка 3',
            self::GLOBAL_TYPE_GALLERY_TILE_6 => 'Галерея Плитка 6',
            self::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_1 => 'Баннер департамента тип 1',
            self::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_2 => 'Баннер департамента тип 2',
            self::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_3 => 'Баннер департамента тип 3',
            self::GLOBAL_TYPE_BANNER_HOMEPAGE_DEPARTMENT_6 => 'Баннер департамента тип 6',
        ];
    }
    
    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        $this->_types[self::TYPE_SETTING] = 'Настройка';
        $this->_types[self::TYPE_BLOCK_READY] = 'Готовые блоки';
        $this->_types[self::TYPE_FORM] = 'Формы';

        return $this->_types;
    }

    /**
     * @return array
     */
    public function getGlobalTypeOptions() : array
    {
        return $this->_globalTypes;
    }

    /**
     * @return array
     */
    public function getExistsGlobalTypeOptions() : array
    {
        $globalTypes = $this->getGlobalTypeOptions();
        $rows = self::find()->select('global_type')->distinct(true)->asArray()->column();

        foreach ($rows as $row) {
            if (!empty($row) && isset($globalTypes[$row])) {
                unset($globalTypes[$row]);
            }
        }

        if ($this->global_type) {
            $globalTypes = ArrayHelper::merge([$this->global_type => $this->getGlobalTypeTitle($this->global_type),], $globalTypes);
        }

        asort($globalTypes);

        return $globalTypes;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        return $this->getTypeOptions()[$type];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeIcon(string $type) : string
    {
        $options = [];

        $options[self::TYPE_GALLERY] = IconHelper::ICON_GALLERY;
        $options[self::TYPE_TEXT] = IconHelper::ICON_TEXT;
        $options[self::TYPE_BANNER] = IconHelper::ICON_BANNER;
        $options[self::TYPE_SLIDER] = IconHelper::ICON_SLIDER;
        $options[self::TYPE_FILTER] = IconHelper::ICON_FILTER;
        $options[self::TYPE_SETTING] = IconHelper::ICON_SETTING;
        $options[self::TYPE_BLOCK_READY] = IconHelper::ICON_READY;
        $options[self::TYPE_FORM] = IconHelper::ICON_FORM;
        $options[self::TYPE_AGGREGATOR] = IconHelper::ICON_AGGREGATOR;

        return $options[$type] ?? IconHelper::ICON_DEFAULT;
    }

    /**
     * @param string $globalType
     *
     * @return string
     */
    public function getGlobalTypeTitle(string $globalType) : string
    {
        return $this->_globalTypes[$globalType];
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
    public static function tableName()
    {
        return 'block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['type', 'in', 'range' => self::TYPES,],
            ['global_type', 'in', 'range' => self::GLOBAL_TYPES,],
            [['description', 'type', 'global_type'], 'string'],
            [['created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['global_type'], 'unique', 'skipOnEmpty' => true,],
            [['sort_list', 'content_block_id', 'content_block_type', 'content_block_sort', 'data',], 'safe',],
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
            'description' => 'Описание',
            'type' => 'Тип',
            'global_type' => 'Глобальный уникальный тип',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'deleted_at' => 'Удалено',
            'content_block_id' => 'content_block_id',
            'content_block_type' => 'content_block_type',
            'content_block_sort' => 'content_block_sort',
            'data' => 'data',
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $saved = parent::save($runValidation, $attributeNames);

        if ($saved && !empty($this->sort_list)) {
            $index = 1;
            $fields = [];
            foreach (explode(',', $this->sort_list) as $id) {
                $fields[$id] = $index++;
            }

            if ($fields) {
                $db = \Yii::$app->db;
                foreach ($fields as $id => $sortIndex) {
                    $db->createCommand()->update(
                        BlockField::tableName(),
                        ['sort' => $sortIndex,],
                        ['id' => $id, 'block_id' => $this->id,]
                    )->execute();
                }
            }
        }

        return $saved;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockFields()
    {
        return $this->hasMany(BlockField::class, ['block_id' => 'id',])->orderBy(['sort' => SORT_ASC,]);
    }

    /**
     * @return int
     */
    public function getBlockFieldsCount() : int
    {
        return $this->getBlockFields()->where([BlockField::tableName().'.deleted_at' => null,])->count('*');
    }

    /**
     * @return bool|false|int
     */
    public function delete()
    {
        $this->deleted_at = time();

        $deleted = $this->save(false);

        return $deleted;
    }

    /**
     * @return int
     */
    public function getUsedCount() : int
    {
        return $this->getContents()->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getContentBlocks()
    {
        return $this->hasMany(ContentBlock::class, ['block_id' => 'id',])->where([ContentBlock::tableName().'.type' => ContentBlock::TYPE_BLOCK,]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(Content::class, ['id' => 'content_id',])
            ->via('contentBlocks');
    }
}
