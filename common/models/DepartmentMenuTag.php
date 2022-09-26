<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "department_menu_tag".
 *
 * @property int            $id
 * @property int            $department_menu_id
 * @property string         $url
 * @property string         $name
 * @property string         $image
 * @property bool           $is_active
 * @property int            $sort
 * @property int            $landing_page_id
 * @property int            $created_at
 * @property int            $updated_at
 *
 * @property DepartmentMenu $departmentMenu
 * @property Content        $landingPage
 */
class DepartmentMenuTag extends \yii\db\ActiveRecord
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
        return 'department_menu_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_menu_id', 'url', 'name', 'sort', 'landing_page_id',], 'required'],
            [['department_menu_id', 'created_at', 'sort', 'updated_at',], 'default', 'value' => null],
            [['department_menu_id', 'created_at', 'sort', 'updated_at', 'landing_page_id',], 'integer'],
            [['is_active',], 'boolean'],
            [['department_menu_id',], 'exist', 'skipOnError' => true, 'targetClass' => DepartmentMenu::class, 'targetAttribute' => ['department_menu_id' => 'id',]],
            [['url',], 'string', 'max' => 25],
            [['name',], 'string', 'max' => 50],
            [['image',], 'string', 'max' => 255],
            [['url', 'name', 'image',], 'trim'],
            [['department_menu_id', 'url',], 'unique', 'targetAttribute' => ['department_menu_id', 'url',],],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department_menu_id' => 'Меню департамента',
            'url' => 'Урл',
            'name' => 'Название',
            'image' => 'Картинка',
            'is_active' => 'Активно',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'landing_page_id' => 'Посадочная страница контента',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartmentMenu()
    {
        return $this->hasOne(DepartmentMenu::class, ['id' => 'department_menu_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLandingPage()
    {
        return $this->hasOne(Content::class, ['id' => 'landing_page_id', 'type' => Content::TYPE_PAGE,]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartmentMenuTagLists()
    {
        return $this->hasMany(DepartmentMenuTagList::class, ['department_menu_tag_id' => 'id',])->where([DepartmentMenuTagList::tableName().'.is_active' => true,]);
    }

    /**
     * @return array
     */
    public static function getMenuOptions() : array
    {
        return ArrayHelper::map(DepartmentMenu::find()->select([DepartmentMenu::tableName().'.id', DepartmentMenu::tableName().'.name',])->where([DepartmentMenu::tableName().'.is_active' => true,])->orderBy([DepartmentMenu::tableName().'.sort' => SORT_ASC,])->asArray()->all(), 'id', 'name');
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return !$this->is_active ? 'danger' : 'default';
    }
}
