<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "parser_jaguarlandroverclassic_items".
 *
 * @property int $id
 * @property int $rubric_id
 * @property int $parent_id
 * @property int $level
 * @property bool $is_product
 * @property string $position Код слева 2B912A, <55100
 * @property string $name
 * @property int $sort
 * @property string $url
 * @property string $description
 * @property bool $is_active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ParserJaguarlandroverclassicItems $parent
 * @property ParserJaguarlandroverclassicItems[] $children
 * @property ParserJaguarlandroverclassicRubrics $rubric
 */
class ParserJaguarlandroverclassicItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_jaguarlandroverclassic_items';
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
            [['rubric_id', 'level', 'name', 'url'], 'required'],
            [['rubric_id', 'parent_id', 'level', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['rubric_id', 'parent_id', 'level', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['is_product', 'is_active'], 'boolean'],
            [['url', 'description'], 'string'],
            [['position', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rubric_id' => 'Рубрика',
            'parent_id' => 'Родитель',
            'level' => 'Уровень',
            'is_product' => 'Товар',
            'position' => 'Позиция',
            'name' => 'Название',
            'sort' => 'Сортировка',
            'url' => 'УРЛ',
            'description' => 'Описание',
            'is_active' => 'Активен',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent(): \yii\db\ActiveQuery
    {
        return $this->hasOne(ParserJaguarlandroverclassicItems::class, ['id' => 'parent_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubric(): \yii\db\ActiveQuery
    {
        return $this->hasOne(ParserJaguarlandroverclassicRubrics::class, ['id' => 'rubric_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren(): \yii\db\ActiveQuery
    {
        return $this->hasMany(ParserJaguarlandroverclassicItems::class, ['parent_id' => 'id',]);
    }
}
