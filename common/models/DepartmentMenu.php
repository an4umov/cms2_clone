<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "department_menu".
 *
 * @property int                 $id
 * @property int                 $department_id
 * @property string              $url
 * @property string              $name
 * @property string              $image
 * @property bool                $is_active
 * @property bool                $is_all_products
 * @property int                 $sort
 * @property string              $landing_page_type
 * @property string              $landing_page_catalog
 * @property int                 $landing_page_id
 * @property int                 $created_at
 * @property int                 $updated_at
 *
 * @property Department          $department
 * @property DepartmentMenuTag[] $departmentMenuTags
 * @property Content             $landingPage
 */
class DepartmentMenu extends \yii\db\ActiveRecord
{
    const DEFAULT_TITLE = 'Все';

    const LANDING_PAGE_TYPE_PAGE = 'page';
    const LANDING_PAGE_TYPE_CATALOG = 'catalog';
    const LANDING_PAGE_TYPES = [self::LANDING_PAGE_TYPE_PAGE, self::LANDING_PAGE_TYPE_CATALOG,];

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
        return 'department_menu';
    }

    public function getStatusTitles() : array
    {
        return [
            self::LANDING_PAGE_TYPE_PAGE => 'Страница',
            self::LANDING_PAGE_TYPE_CATALOG => 'Каталог',
        ];
    }

    public function getStatusTitle(string $status) : string
    {
        return $this->getStatusTitles()[$status];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_id', 'url', 'name', 'sort', 'landing_page_type',], 'required'],
            [['department_id', 'sort', 'created_at', 'updated_at', 'landing_page_id', 'landing_page_catalog',], 'default', 'value' => null],
            [['department_id', 'sort', 'created_at', 'updated_at', 'landing_page_id',], 'integer'],
            [['is_active', 'is_all_products',], 'boolean'],
            [['url', 'landing_page_catalog',], 'string', 'max' => 25],
            [['name',], 'string', 'max' => 255],
            [['image',], 'string', 'max' => 255],
            [['url', 'name', 'image',], 'trim'],
            [['is_active', 'is_all_products',], 'default', 'value' => false,],
            [['department_id', 'url',], 'unique', 'targetAttribute' => ['department_id', 'url',],],
            [['department_id',], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id',]],
            ['landing_page_type', 'in', 'range' => self::LANDING_PAGE_TYPES,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'department_id' => 'Департамент',
            'url' => 'Урл',
            'name' => 'Название',
            'image' => 'Картинка',
            'is_active' => 'Активно',
            'is_all_products' => 'Все товары раздела',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'landing_page_id' => 'Посадочная страница контента',
            'landing_page_type' => 'Тип посадочной страницы',
            'landing_page_catalog' => 'Код каталога',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartmentMenuTags()
    {
        return $this->hasMany(DepartmentMenuTag::class, ['department_menu_id' => 'id',]);
    }

    /**
     * @return array
     */
    public static function getDepartmentOptions() : array
    {
        return ArrayHelper::map(Department::find()->select([Department::tableName().'.id', Department::tableName().'.name',])->where([Department::tableName().'.is_active' => true,])->orderBy([Department::tableName().'.sort' => SORT_ASC,])->asArray()->all(), 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLandingPage()
    {
        return $this->hasOne(Content::class, ['id' => 'landing_page_id', 'type' => Content::TYPE_PAGE,]);
    }

    /**
     * @return int
     */
    public function getTagCount() : int
    {
        return $this->getDepartmentMenuTags()->count();
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        if (!$this->is_active) {
            return 'danger';
        }

        if ($this->is_all_products) {
            return 'success';
        }

        return 'default';
    }

    /**
     * @return bool
     */
    public function isLandingMenu() : bool
    {
        return $this->isNewRecord ? false : ($this->department ? Department::find()->where(['landing_menu_id' => $this->id, 'id' => $this->department_id,])->exists() : false);
    }

    /**
     * @return false|int|void
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        $tags = $this->getDepartmentMenuTags()->all();

        foreach ($tags as $tag) {
            $tag->delete();
        }

        return parent::delete();
    }
}
