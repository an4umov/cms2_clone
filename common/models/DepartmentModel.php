<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "department_model".
 *
 * @property int $id
 * @property int $department_id
 * @property string $word_1
 * @property string $word_2
 * @property string $default_title
 * @property string $url
 * @property string $image
 * @property bool $is_active
 * @property int $landing_page_id
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Department $department
 * @property DepartmentMenu[]  $departmentMenus
 * @property DepartmentModelList[] $departmentModelLists
 * @property Content           $landingPage
 */
class DepartmentModel extends \yii\db\ActiveRecord
{
    const DEFAULT_TITLE = 'Выбрать марку';

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
        return 'department_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_id', 'word_1', 'url', 'sort',], 'required'],
            [['department_id', 'created_at', 'updated_at','sort', ], 'default', 'value' => null],
            [['department_id', 'created_at', 'updated_at', 'sort', 'landing_page_id', ], 'integer'],
            [['word_1', 'word_2',], 'string', 'max' => 50],
            [['default_title',], 'string', 'max' => 255],
            [['word_1', 'word_2',], 'trim',],
            [['is_active',], 'boolean'],
            [['url',], 'string', 'max' => 25],
            [['image',], 'string', 'max' => 255],
            [['url', 'image',], 'trim'],
            [['is_active',], 'default', 'value' => false,],
            [['department_id', 'url',], 'unique', 'targetAttribute' => ['department_id', 'url',],],
            [['department_id',], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id',]],
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
            'word_1' => 'Первое слово',
            'word_2' => 'Второе слово',
            'default_title' => 'Название пункта "По умолчанию"',
            'url' => 'Урл',
            'icon' => 'Иконка',
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
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartmentModelLists()
    {
        return $this->hasMany(DepartmentModelList::class, ['department_model_id' => 'id',])->where([DepartmentModelList::tableName().'.is_active' => true,])->orderBy([DepartmentModelList::tableName().'.sort' => SORT_ASC,]);
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
    public function getListCount() : int
    {
        return $this->getDepartmentModelLists()->count();
    }

    /**
     * @return array
     */
    public static function getModelOptions() : array
    {
        $list = [];
        $rows = DepartmentModel::find()
            ->select([DepartmentModel::tableName().'.id', DepartmentModel::tableName().'.word_1', DepartmentModel::tableName().'.word_2',])
            ->orderBy([DepartmentModel::tableName().'.id' => SORT_ASC,])
            ->asArray()
            ->all();

        foreach ($rows as $row) {
            $list[] = ['id' => $row['id'], 'name' => $row['word_1'].(!empty($row['word_2']) ? ' '.$row['word_2'] : ''),];
        }

        return ArrayHelper::map($list, 'id', 'name');
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartmentMenus()
    {
        return $this->hasMany(DepartmentMenu::class, ['department_model_id' => 'id',]);
    }

    /**
     * @return int
     */
    public function getDepartmentMenuCount() : int
    {
        return $this->getDepartmentMenus()->count();
    }
}
