<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content_filter_page".
 *
 * @property int $id
 * @property int $content_id
 * @property string $type
 * @property int $department_content_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Content $content
 */
class ContentFilterPage extends \yii\db\ActiveRecord
{
    const TYPE_DEPARTMENT = 'department';
    const TYPE_DEPARTMENT_MODEL = 'department_model';
    const TYPE_DEPARTMENT_MENU = 'department_menu';

    const TYPES = [self::TYPE_DEPARTMENT, self::TYPE_DEPARTMENT_MODEL, self::TYPE_DEPARTMENT_MENU,];

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
        return 'content_filter_page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'department_content_id'], 'required'],
            [['content_id', 'department_content_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'department_content_id', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string'],
            ['type', 'in', 'range' => self::TYPES,],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::class, 'targetAttribute' => ['content_id' => 'id']],
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
            'department_content_id' => 'Контент структуры',
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
