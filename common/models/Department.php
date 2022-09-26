<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "department".
 *
 * @property int               $id
 * @property string            $url
 * @property string            $name
 * @property string            $icon
 * @property string            $image
 * @property string            $catalog_code
 * @property bool              $is_active
 * @property bool              $is_default
 * @property int               $sort
 * @property int               $default_menu_id
 * @property int               $landing_menu_id
 * @property int               $landing_page_id
 * @property int               $created_at
 * @property int               $updated_at
 *
 * @property DepartmentMenu    $landing
 * @property DepartmentMenu    $defaultMenu
 * @property Content           $landingPage
 * @property DepartmentMenu[]  $departmentMenus
 */
class Department extends \yii\db\ActiveRecord
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
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'name', 'sort',], 'required'],
            [['url', 'name', 'icon', 'image', 'catalog_code',], 'trim'],
            [['is_active', 'is_default',], 'boolean'],
            [['sort', 'created_at', 'updated_at', 'default_menu_id',], 'default', 'value' => null],
            [['sort', 'created_at', 'updated_at', 'landing_page_id', 'default_menu_id',], 'integer'],
            [['url'], 'string', 'max' => 150,],
            [['name', 'image', 'catalog_code',], 'string', 'max' => 255,],
            [['icon'], 'string', 'max' => 50,],
            [['url'], 'unique'],
            [['is_active', 'is_default',], 'default', 'value' => false,],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Урл',
            'name' => 'Название',
            'icon' => 'Иконка',
            'image' => 'Картинка',
            'catalog_code' => 'Код каталога',
            'is_active' => 'Активно',
            'is_default' => 'По умолчанию',
            'sort' => 'Сортировка',
            'landing_menu_id' => 'Посадочная страница (меню)',
            'default_menu_id' => 'Пункт меню по умолчанию',
            'landing_page_id' => 'Посадочная страница контента',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanding()
    {
        return $this->hasOne(DepartmentMenu::class, ['id' => 'landing_menu_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDefaultMenu()
    {
        return $this->hasOne(DepartmentMenu::class, ['id' => 'default_menu_id',]);
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
    public function getDepartmentMenus()
    {
        return $this->hasMany(DepartmentMenu::class, ['department_id' => 'id',]);
    }

    /**
     * @return int
     */
    public function getDepartmentMenuCount() : int
    {
        return $this->getDepartmentMenus()->count();
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return $this->is_default ? 'success' : (!$this->is_active ? 'danger' : 'default');
    }

    /**
     * @return array
     */
    public function getLandingOptions() : array
    {
        $query = DepartmentMenu::find()->where(['department_id' => $this->id, 'is_active' => true,])->orderBy(['sort' => SORT_ASC,])->asArray();

        if (!empty($this->landing_menu_id)) {
//            $query->andWhere(['<>', 'id', $this->landing_menu_id]);
        }

        return ArrayHelper::map($query->all(), 'id', 'name');
    }

    /**
     * @return bool
     */
    public function getIsDefaultState() : bool
    {
        $defaultModel = Department::findOne(['is_default' => true,]);

        if (!empty($defaultModel)) {
            if ($this->id == $defaultModel->id) {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * @return false|int|void
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        $menus = $this->getDepartmentMenus()->all();

        foreach ($menus as $menu) {
            $menu->delete();
        }

        return parent::delete();
    }
}
