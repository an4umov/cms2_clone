<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "department_menu_tag_list".
 *
 * @property int $id
 * @property int $department_menu_tag_id
 * @property string $url
 * @property string $name
 * @property string $icon
 * @property bool $is_active
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DepartmentMenuTag $departmentMenuTag
 */
class DepartmentMenuTagList extends \yii\db\ActiveRecord
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
        return 'department_menu_tag_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_menu_tag_id', 'url', 'name', 'sort',], 'required'],
            [['department_menu_tag_id', 'sort', 'created_at', 'updated_at',], 'default', 'value' => null],
            [['department_menu_tag_id', 'sort', 'created_at', 'updated_at',], 'integer'],
            [['is_active',], 'boolean'],
            [['url',], 'string', 'max' => 25],
            [['name', 'icon',], 'string', 'max' => 50],
            [['url', 'name', 'icon',], 'trim'],
            [['department_menu_tag_id', 'url',], 'unique', 'targetAttribute' => ['department_menu_tag_id', 'url',],],
            [['department_menu_tag_id',], 'exist', 'skipOnError' => true, 'targetClass' => DepartmentMenuTag::class, 'targetAttribute' => ['department_menu_tag_id' => 'id',]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department_menu_tag_id' => 'Тематика меню департамента',
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
    public function getDepartmentMenuTag()
    {
        return $this->hasOne(DepartmentMenuTag::class, ['id' => 'department_menu_tag_id',]);
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return !$this->is_active ? 'danger' : 'default';
    }

    /**
     * @param int $departmentMenuID
     *
     * @return array
     */
    public static function getDepartmentMenuTagOptions(int $departmentMenuID) : array
    {
        return ArrayHelper::map(DepartmentMenuTag::find()->select([DepartmentMenuTag::tableName().'.id', DepartmentMenuTag::tableName().'.id as name',])->where([DepartmentMenuTag::tableName().'.is_active' => true, DepartmentMenuTag::tableName().'.department_menu_id' => $departmentMenuID,])->orderBy([DepartmentMenuTag::tableName().'.id' => SORT_ASC,])->asArray()->all(), 'id', 'name');
    }
}
