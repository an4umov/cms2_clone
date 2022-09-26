<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "form_field".
 *
 * @property int $id
 * @property int $form_id
 * @property string $name
 * @property string $data JSON
 * @property string $type
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property Form $form
 */
class FormField extends \yii\db\ActiveRecord
{
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_TEXT = 'text';
    const TYPE_EMAIL = 'email';
    const TYPE_PHONE = 'phone';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_REFERENCE_ID = 'reference_id';
    const TYPE_BUTTON = 'button';
    const TYPE_MESSAGE = 'message';

    const TYPES = [
        self::TYPE_TEXTAREA,
        self::TYPE_TEXT,
        self::TYPE_EMAIL,
        self::TYPE_PHONE,
        self::TYPE_CHECKBOX,
        self::TYPE_REFERENCE_ID,
        self::TYPE_BUTTON,
        self::TYPE_MESSAGE,
    ];

    public $value;
    private $_types;

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_TEXTAREA => 'Текст без формата',
            self::TYPE_TEXT => 'Текстовое поле',
            self::TYPE_EMAIL => 'Эл. почта',
            self::TYPE_PHONE => 'Телефон',
            self::TYPE_CHECKBOX => 'Чекбокс',
            self::TYPE_REFERENCE_ID => 'Справочник',
            self::TYPE_BUTTON => 'Кнопка отсылки',
            self::TYPE_MESSAGE => 'Произвольный текст',
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
        return 'form_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'name', 'data'], 'required'],
            [['form_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['form_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['type', 'data',], 'string'],
            [['name'], 'string', 'max' => 128],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Form::class, 'targetAttribute' => ['form_id' => 'id',]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Форма',
            'name' => 'Название',
            'data' => 'Данные',
            'type' => 'Тип',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'deleted_at' => 'Удалено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Form::class, ['id' => 'form_id',]);
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
     * @return array
     */
    public function getData() : array
    {
        return !empty($this->data) ? Json::decode($this->data) : [];
    }

    /**
     * @return string
     */
    public function getRawData() : string
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = Json::encode($data);
    }
}
