<?php

namespace common\models;


use backend\components\helpers\IconHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "block_field".
 *
 * @property int $id
 * @property int $block_id
 * @property string $name
 * @property string $type
 * @property string $description
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property Block $block
 * @property BlockFieldList[] $blockFieldLists
 * @property BlockFieldValuesList[] $blockFieldValuesLists
 */
class BlockField extends \yii\db\ActiveRecord
{
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_TEXTAREA_EXT = 'textarea_ext';
    const TYPE_IMAGE = 'image';
    const TYPE_BOOL = 'bool';
    const TYPE_DATE = 'date';
    const TYPE_COLOR = 'color';
    const TYPE_GRADIENT_COLOR = 'gradient_color';
    const TYPE_DIGIT = 'digit';
    const TYPE_TEXT = 'text';
    const TYPE_ARTICLE_ID = 'article_id';
    const TYPE_PAGE_ID = 'page_id';
    const TYPE_LIST = 'list';
    const TYPE_VALUES_LIST = 'values_list';
    const TYPE_TAGS = 'tags';
    const TYPE_FORMS = 'forms';
    const TYPE_DEPARTMENTS = 'departments';
    const TYPE_MANUFACTURERS = 'manufacturers';
    const TYPE_FULL_PRICE_TAGS = 'full_price_tags';
    const TYPE_SPECIAL_GROUP = 'special_group';
    const TYPE_SPECIAL_FLAG = 'special_flag';
    const TYPE_CONTENT_ID = 'content_id';
    const TYPE_STRUCTURE_ID = 'structure_id';

    const GRADIENT_COLOR_LEFT = 'left';
    const GRADIENT_COLOR_CENTER = 'center';
    const GRADIENT_COLOR_RIGHT = 'right';

    const TYPES = [
        self::TYPE_TEXTAREA,
        self::TYPE_TEXTAREA_EXT,
        self::TYPE_IMAGE,
        self::TYPE_BOOL,
        self::TYPE_DATE,
        self::TYPE_COLOR,
        self::TYPE_GRADIENT_COLOR,
        self::TYPE_DIGIT,
        self::TYPE_TEXT,
        self::TYPE_ARTICLE_ID,
        self::TYPE_PAGE_ID,
        self::TYPE_LIST,
        self::TYPE_VALUES_LIST,
        self::TYPE_TAGS,
        self::TYPE_FORMS,
        self::TYPE_DEPARTMENTS,
        self::TYPE_MANUFACTURERS,
        self::TYPE_FULL_PRICE_TAGS,
        self::TYPE_SPECIAL_GROUP,
        self::TYPE_SPECIAL_FLAG,
        self::TYPE_CONTENT_ID,
        self::TYPE_STRUCTURE_ID,
    ];

    private $_types;
    private $_typeClasses;
    private $_typeIcons;
    public $sort_list;
    public $list;
    public $values_list;

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_TEXTAREA => 'Текст без формата',
            self::TYPE_TEXTAREA_EXT => 'Текст с форматом',
            self::TYPE_IMAGE => 'Картинка',
            self::TYPE_BOOL => 'Булево',
            self::TYPE_DATE => 'Дата',
            self::TYPE_COLOR => 'Цвет',
            self::TYPE_GRADIENT_COLOR => 'Градиентная заливка',
            self::TYPE_DIGIT => 'Цифры',
            self::TYPE_TEXT => 'Текстовое поле',
            self::TYPE_ARTICLE_ID => 'Ссылка на статью',
            self::TYPE_PAGE_ID => 'Ссылка на страницу',
            self::TYPE_LIST => 'Список полей Повторитель',
            self::TYPE_VALUES_LIST => 'Список значений',
            self::TYPE_TAGS => 'Список тегов',
            self::TYPE_FORMS => 'Список форм',
            self::TYPE_DEPARTMENTS => 'Список департаментов',
            self::TYPE_MANUFACTURERS => 'Список производителей',
            self::TYPE_FULL_PRICE_TAGS => 'Список товарных тегов',
            self::TYPE_SPECIAL_GROUP => 'Фильтр по Группировке',
            self::TYPE_SPECIAL_FLAG => 'Фильтр по Флагу',
            self::TYPE_CONTENT_ID => 'Ссылка на контент',
            self::TYPE_STRUCTURE_ID => 'Фильтр по структуре',
        ];

        $this->_typeClasses = [
            self::TYPE_TEXTAREA => 'label label-default',
            self::TYPE_TEXTAREA_EXT => 'label label-default',
            self::TYPE_IMAGE => 'label label-success',
            self::TYPE_BOOL => 'label label-inverse',
            self::TYPE_DATE => 'label label-info',
            self::TYPE_COLOR => 'label label-warning',
            self::TYPE_GRADIENT_COLOR => 'label label-warning',
            self::TYPE_DIGIT => 'label label-inverse',
            self::TYPE_TEXT => 'label label-default',
            self::TYPE_ARTICLE_ID => 'label label-primary',
            self::TYPE_PAGE_ID => 'label label-primary',
            self::TYPE_LIST => 'label label-danger',
            self::TYPE_VALUES_LIST => 'label label-danger',
            self::TYPE_TAGS => 'label label-success',
            self::TYPE_FORMS => 'label label-inverse',
            self::TYPE_DEPARTMENTS => 'label label-warning',
            self::TYPE_MANUFACTURERS => 'label label-danger',
            self::TYPE_FULL_PRICE_TAGS => 'label label-primary',
            self::TYPE_SPECIAL_GROUP => 'label label-success',
            self::TYPE_SPECIAL_FLAG => 'label label-info',
            self::TYPE_CONTENT_ID => 'label label-primary',
            self::TYPE_STRUCTURE_ID => 'label label-danger',
        ];

        $this->_typeIcons = [
            self::TYPE_TEXTAREA => 'far fa-square',
            self::TYPE_TEXTAREA_EXT => 'fa fa-credit-card',
            self::TYPE_IMAGE => 'far fa-image',
            self::TYPE_BOOL => 'fa fa-adjust',
            self::TYPE_DATE => 'fa fa-calendar',
            self::TYPE_COLOR => 'fas fa-palette',
            self::TYPE_GRADIENT_COLOR => 'fas fa-fill-drip',
            self::TYPE_DIGIT => 'fas fa-sort-numeric-down',
            self::TYPE_TEXT => 'fas fa-font',
            self::TYPE_ARTICLE_ID => 'far fa-newspaper',
            self::TYPE_PAGE_ID => 'fa fa-book',
            self::TYPE_LIST => 'fa fa-list-ul',
            self::TYPE_VALUES_LIST => 'fas fa-bars',
            self::TYPE_TAGS => IconHelper::ICON_TAGS,
            self::TYPE_FORMS => IconHelper::ICON_FORM,
            self::TYPE_DEPARTMENTS => IconHelper::ICON_DEPARTMENT,
            self::TYPE_MANUFACTURERS => IconHelper::ICON_MANUFACTURERS,
            self::TYPE_FULL_PRICE_TAGS => IconHelper::ICON_TAGS,
            self::TYPE_SPECIAL_GROUP => IconHelper::ICON_SPECIAL_GROUP,
            self::TYPE_SPECIAL_FLAG => IconHelper::ICON_SPECIAL_FLAG,
            self::TYPE_CONTENT_ID => IconHelper::ICON_PAGES,
            self::TYPE_STRUCTURE_ID => IconHelper::ICON_STRUCTURES,
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
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        return $this->_types[$type];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeClass(string $type) : string
    {
        return $this->_typeClasses[$type];
    }

    /**
     * @return array
     */
    public function getTypeClasses() : array
    {
        return $this->_typeClasses;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeIcon(string $type) : string
    {
        return $this->_typeIcons[$type];
    }

    /**
     * @return array
     */
    public function getTypeIcons() : array
    {
        return $this->_typeIcons;
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
        return 'block_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_id', 'name'], 'required'],
            [['block_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['block_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['type', 'description',], 'string'],
            ['type', 'in', 'range' => self::TYPES,],
            [['name'], 'string', 'max' => 128],
            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::class, 'targetAttribute' => ['block_id' => 'id',],],
            [['sort_list', 'list', 'values_list',], 'safe',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'block_id' => 'Блок',
            'name' => 'Название',
            'type' => 'Тип',
            'description' => 'Пояснение к полю',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'deleted_at' => 'Удалено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::class, ['id' => 'block_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockFieldLists()
    {
        return $this->hasMany(BlockFieldList::class, ['field_id' => 'id',])->orderBy([BlockFieldList::tableName().'.sort' => SORT_ASC,]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockFieldValuesLists()
    {
        return $this->hasMany(BlockFieldValuesList::class, ['field_id' => 'id',])->orderBy([BlockFieldValuesList::tableName().'.sort' => SORT_ASC,]);
    }

    /**
     * @return array
     */
    public function getBlockFieldValuesOptions()
    {
        $rows = $this->getBlockFieldValuesLists()->andWhere([BlockFieldValuesList::tableName().'.deleted_at' => null])->all();

        return ArrayHelper::map($rows, 'id', 'value');
    }

    /**
     * @return bool
     */
    public function delete() : bool
    {
        $this->deleted_at = time();

        return (bool) $this->save(false);
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function _deleteFieldList() : void
    {
        foreach ($this->getBlockFieldLists()->all() as $model) {
            $model->delete();
        }
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    private function _deleteFieldValuesList() : void
    {
        foreach ($this->getBlockFieldValuesLists()->all() as $model) {
            $model->delete();
        }
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $saved = parent::save($runValidation, $attributeNames);

        if ($saved) {
            if ($this->type === self::TYPE_LIST && !empty($this->list)) {
                $sortIndex = 1;
                $existsList = $this->getBlockFieldLists()->indexBy('id')->all();

                foreach ($this->list['id'] as $index => $id) {
                    $name = $this->list['name'][$index] ?? '';
                    $description = $this->list['description'][$index] ?? null;
                    $type = $this->list['type'][$index] ?? '';

                    if (empty($id)) {
                        $listModel = new BlockFieldList();
                        $listModel->field_id = $this->id;
                    } else {
                        $listModel = BlockFieldList::findOne(['id' => $id, 'field_id' => $this->id,]);

                        if (empty($listModel)) {
                            continue;
                        }
                    }

                    if ($listModel->isNewRecord) {
                        if (empty($name) || empty($type)) {
                            continue;
                        }
                    } else {
                        if (empty($type)) {
                            unset($existsList[$listModel->id]);

                            continue;
                        }

                        $name = $listModel->name;
                    }

                    $listModel->sort = $sortIndex++;
                    $listModel->name = $name;
                    $listModel->type = $type;
                    $listModel->description = $description;

                    $listModel->save();

                    unset($existsList[$listModel->id]);
                }

                foreach ($existsList as $item) {
                    $item->delete();
                }
            } elseif ($this->type === self::TYPE_VALUES_LIST && !empty($this->values_list)) {
                $sortIndex = 1;
                $existsList = $this->getBlockFieldValuesLists()->indexBy('id')->all();

                foreach ($this->values_list['id'] as $index => $id) {
                    $value = $this->values_list['value'][$index] ?? '';

                    if (empty($value)) {
                        continue;
                    }

                    if (empty($id)) {
                        $listModel = new BlockFieldValuesList();
                        $listModel->field_id = $this->id;
                    } else {
                        $listModel = BlockFieldValuesList::findOne(['id' => $id, 'field_id' => $this->id,]);

                        if (empty($listModel)) {
                            continue;
                        }
                    }

                    $listModel->sort = $sortIndex++;
                    $listModel->value = $value;
                    $listModel->save();

                    unset($existsList[$listModel->id]);
                }

                foreach ($existsList as $item) {
                    $item->delete();
                }
            } else {
                $this->_deleteFieldList();
                $this->_deleteFieldValuesList();
            }
        }

        return $saved;
    }
}
