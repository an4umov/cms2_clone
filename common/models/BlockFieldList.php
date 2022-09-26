<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "block_field_list".
 *
 * @property int $id
 * @property int $field_id
 * @property string $name
 * @property string $type
 * @property string $description
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property BlockField $field
 */
class BlockFieldList extends \yii\db\ActiveRecord
{
    const TYPES = [
        BlockField::TYPE_TEXTAREA,
        BlockField::TYPE_TEXTAREA_EXT,
        BlockField::TYPE_IMAGE,
        BlockField::TYPE_BOOL,
        BlockField::TYPE_DATE,
        BlockField::TYPE_COLOR,
        BlockField::TYPE_DIGIT,
        BlockField::TYPE_TEXT,
        BlockField::TYPE_ARTICLE_ID,
        BlockField::TYPE_PAGE_ID,
        BlockField::TYPE_LIST,
    ];

    /** @var array */
    private $_types;

    /** @var BlockField */
    private $_field;

    public function init()
    {
        parent::init();

        $this->_field = new BlockField();
        $this->_types = $this->_field->getTypeOptions();
        unset($this->_types[BlockField::TYPE_LIST]);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeClass(string $type) : string
    {
        return $this->_field->getTypeClasses()[$type];
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeIcon(string $type) : string
    {
        return $this->_field->getTypeIcons()[$type];
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
        return 'block_field_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'name'], 'required'],
            [['field_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['field_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['type', 'description',], 'string'],
            ['type', 'in', 'range' => self::TYPES,],
            [['name'], 'string', 'max' => 128],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlockField::class, 'targetAttribute' => ['field_id' => 'id',]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Поле',
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
    public function getField()
    {
        return $this->hasOne(BlockField::class, ['id' => 'field_id',]);
    }

    public function delete()
    {
        $this->deleted_at = time();

        $deleted = $this->save(false);

        return $deleted;
    }
}
