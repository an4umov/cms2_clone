<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "green_menu".
 *
 * @property int $id
 * @property string $title
 * @property int $landing_page_id
 * @property int $sort
 * @property bool $is_enabled
 * @property bool $is_department_menu  Может быть только один
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Content $landingPage
 */
class GreenMenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'green_menu';
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
    public function rules()
    {
        return [
            [['title', 'landing_page_id', 'sort'], 'required'],
            [['landing_page_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['landing_page_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['is_enabled', 'is_department_menu',], 'boolean'],
            [['is_department_menu',], 'default', 'value' => false,],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'landing_page_id' => 'Посадочная страница пункта меню',
            'sort' => 'Сортировка',
            'is_enabled' => 'Включено',
            'is_department_menu' => 'Группы товаров',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLandingPage()
    {
        return $this->hasOne(Content::class, ['id' => 'landing_page_id',])->where(['type' => Content::TYPE_PAGE,]);
    }

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $saved = parent::save($runValidation, $attributeNames);

        if ($this->is_department_menu) {
            self::updateAll(['is_department_menu' => false,], ['!=', 'id', $this->id,]);
        }

        return $saved;
    }
}
