<?php

namespace common\models;


use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "block_field_values_list".
 *
 * @property int $id
 * @property int $field_id
 * @property string $value
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property BlockField $field
 */
class BlockFieldValuesList extends \yii\db\ActiveRecord
{
    const VALUE_STANDART = 'Стандартный';
    const VALUE_FANTASY = 'Фантазия';

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
        return 'block_field_values_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'value'], 'required'],
            [['field_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['field_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['value'], 'string', 'max' => 128],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlockField::class, 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_id' => 'Поле',
            'value' => 'Значение',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'deleted_at' => 'Удалено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(BlockField::class, ['id' => 'field_id',]);
    }

    public function delete()
    {
        $this->deleted_at = time();

        $deleted = $this->save(false);

        return $deleted;
    }
}
