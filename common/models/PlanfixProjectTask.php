<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "planfix_project_task".
 *
 * @property int $id
 * @property int $planfix_id
 * @property string $type
 * @property int $parent_id
 * @property string $email
 * @property string $title
 * @property string $description
 * @property string $status
 * @property bool $is_active
 * @property string $favoriteData JSON
 * @property string $link
 * @property int $created_at
 * @property int $updated_at
 */
class PlanfixProjectTask extends \yii\db\ActiveRecord
{
    const CUSTOM_VALUE_EXPORT_1C_ID = 51256;

    const TYPE_PROJECT = 'project';
    const TYPE_TASK = 'task';
    const TYPES = [self::TYPE_PROJECT, self::TYPE_TASK];

    private $_types;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'planfix_project_task';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_PROJECT => 'Проект',
            self::TYPE_TASK => 'Задача',
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
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['planfix_id'], 'required'],
            [['planfix_id', 'parent_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['planfix_id', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['type', 'description'], 'string'],
            [['is_active'], 'boolean'],
            [['email', 'title', 'favoriteData', 'link'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 50],
            ['type', 'in', 'range' => self::TYPES,],
            [['planfix_id', 'type'], 'unique', 'targetAttribute' => ['planfix_id', 'type',]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'planfix_id' => 'Planfix ID',
            'type' => 'Тип',
            'parent_id' => 'Родитель',
            'email' => 'Email',
            'title' => 'Название',
            'description' => 'Описание',
            'status' => 'Статус',
            'is_active' => 'Активно',
            'favoriteData' => 'В избранном',
            'link' => 'Ссылка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
}
