<?php

namespace common\models;


/**
 * This is the model class for table "reference_value".
 *
 * @property int $id
 * @property int $reference_id
 * @property string $name
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property Reference $reference
 */
class ReferenceValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reference_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reference_id', 'name'], 'required'],
            [['reference_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['reference_id', 'sort', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['reference_id'], 'exist', 'skipOnError' => true, 'targetClass' => Reference::class, 'targetAttribute' => ['reference_id' => 'id',]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reference_id' => 'Справочник',
            'name' => 'Значение',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'deleted_at' => 'Удалено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReference()
    {
        return $this->hasOne(Reference::class, ['id' => 'reference_id',]);
    }

    /**
     * @return bool
     */
    public function delete() : bool
    {
        $this->deleted_at = time();

        return (bool) $this->save(false);
    }
}
