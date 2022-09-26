<?php

namespace backend\models;

use common\behaviors\Slug;
use Yii;

/**
 * This is the model class for table "templates".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $active
 * @property string $type
 * @property string $alias [varchar(255)]
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     *  template type - free template
     */
    const TYPE_FREE = 'free';
    /**
     * template type - material preview
     */
    const TYPE_MATERIAL_PREVIEW = 'material_preview';

    protected static $types = [
        self::TYPE_FREE => "Свободный шаблон",
        self::TYPE_MATERIAL_PREVIEW => "Превью материала"
    ];

    /**
     * @return array
     */
    public static function getTypes()// : array
    {
        return self::$types;
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getTypeName($type)
    {
        return self::$types[$type];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'templates';
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => 'common\behaviors\Slug',
                'in_attribute' => 'name',
                'out_attribute' => 'alias',
                'translit' => true
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['active', 'type'], 'default', 'value' => null],
            [['active'], 'integer'],
            [['type'], 'string', 'max' => 64],
            [['name', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'content' => 'Содержание',
            'active' => 'Активен',
            'type' => 'Тип',
            'alias' => 'Алиас'
        ];
    }
}
