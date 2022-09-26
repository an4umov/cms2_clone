<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "widget_template".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property array $fields
 * @property integer $parent
 * @property string $title [varchar(255)]
 */
class WidgetTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'widget_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['parent'], 'integer'],
            [['fields'], 'safe'],
            [['name', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'content' => 'Content',
            'fields' => 'Fields',
            'parent' => 'Родительский шаблон',
            'title' => 'Название шаблона'
        ];
    }
}
