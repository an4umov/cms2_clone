<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "settings_footer_item".
 *
 * @property int $id
 * @property int $footer_id
 * @property string $name
 * @property string $url
 * @property bool $is_active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SettingsFooter $footer
 */
class SettingsFooterItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'settings_footer_item';
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
            [['footer_id', 'name', 'url'], 'required'],
            [['footer_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['footer_id', 'created_at', 'updated_at'], 'integer'],
            [['is_active'], 'boolean'],
            [['name', 'url'], 'string', 'max' => 255],
            [['footer_id'], 'exist', 'skipOnError' => true, 'targetClass' => SettingsFooter::class, 'targetAttribute' => ['footer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'footer_id' => 'Блок',
            'name' => 'Название',
            'url' => 'Ссылка',
            'is_active' => 'Активен',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFooter()
    {
        return $this->hasOne(SettingsFooter::class, ['id' => 'footer_id',]);
    }
}
