<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content_filter".
 *
 * @property int     $id
 * @property int     $content_id
 * @property string  $type
 * @property int     $list_id
 * @property int     $created_at
 * @property int     $updated_at
 *
 * @property Content $content
 */
class ContentFilter extends \yii\db\ActiveRecord
{
    const TYPE_TAG = 'tag';
    const TYPE_MODEL = 'model';
    const TYPE_PAGES = 'pages';
    const TYPE_DEPARTMENT = 'department';
    const TYPE_MENU = 'menu';

    const TYPES = [
        self::TYPE_DEPARTMENT,
        self::TYPE_MODEL,
        self::TYPE_MENU,
        self::TYPE_TAG,
    ];

    private $_types;

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_DEPARTMENT => 'Департамент',
            self::TYPE_MODEL => 'Модель',
            self::TYPE_MENU => 'Меню',
            self::TYPE_TAG => 'Тематика',
        ];
    }

    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        return $this->_types;
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
        return 'content_filter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'list_id'], 'required'],
            [['content_id', 'list_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'list_id', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string'],
            ['type', 'in', 'range' => self::TYPES,],
            [
                ['content_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Content::class,
                'targetAttribute' => ['content_id' => 'id',],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Контент',
            'type' => 'Тип',
            'list_id' => 'Фильтр',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::class, ['id' => 'content_id',]);
    }
}
