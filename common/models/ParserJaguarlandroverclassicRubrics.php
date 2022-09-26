<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "parser_jaguarlandroverclassic_rubrics".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property int $sort
 * @property string $url
 * @property string $description
 * @property string $image
 * @property bool $is_active
 * @property bool $is_last
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ParserJaguarlandroverclassicRubrics[] $children
 * @property ParserJaguarlandroverclassicRubrics $parent
 */
class ParserJaguarlandroverclassicRubrics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_jaguarlandroverclassic_rubrics';
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
            [['parent_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['parent_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['name', 'url'], 'required'],
            [['url', 'description'], 'string'],
            [['is_active', 'is_last'], 'boolean'],
            [['name', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'name' => 'Название',
            'sort' => 'Сортировка',
            'url' => 'УРЛ',
            'description' => 'Описание',
            'image' => 'Изображение',
            'is_active' => 'Активен',
            'is_last' => 'Конечная',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(ParserJaguarlandroverclassicRubrics::class, ['parent_id' => 'id',])->where(['is_active' => true,])->orderBy(['sort_field' => SORT_ASC,]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ParserJaguarlandroverclassicRubrics::class, ['id' => 'parent_id',]);
    }
}
