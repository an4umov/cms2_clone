<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "department_model_list".
 *
 * @property int $id
 * @property int $department_model_id
 * @property string $url
 * @property string $name
 * @property string $icon
 * @property bool $is_active
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DepartmentModel $departmentModel
 */
class DepartmentModelList extends \yii\db\ActiveRecord
{
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
        return 'department_model_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_model_id', 'url', 'name', 'sort',], 'required'],
            [['department_model_id', 'sort', 'created_at', 'updated_at',], 'default', 'value' => null],
            [['department_model_id', 'sort', 'created_at', 'updated_at',], 'integer'],
            [['is_active',], 'boolean'],
            [['url',], 'string', 'max' => 25],
            [['name',], 'string', 'max' => 255],
            [['icon',], 'string', 'max' => 50],
            [['url', 'name', 'icon',], 'trim'],
            [['is_active',], 'default', 'value' => false,],
            [['department_model_id', 'url',], 'unique', 'targetAttribute' => ['department_model_id', 'url',],],
            [['department_model_id',], 'exist', 'skipOnError' => true, 'targetClass' => DepartmentModel::class, 'targetAttribute' => ['department_model_id' => 'id',],],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department_model_id' => 'Модель департамента',
            'url' => 'Урл',
            'name' => 'Название',
            'icon' => 'Иконка',
            'is_active' => 'Активно',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartmentModel()
    {
        return $this->hasOne(DepartmentModel::class, ['id' => 'department_model_id',]);
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return !$this->is_active ? 'danger' : 'default';
    }
}
