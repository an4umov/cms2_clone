<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "block_ready_field_values_list".
 *
 * @property int $id
 * @property int $field_id
 * @property string $value
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BlockReadyField $field
 */
class BlockReadyFieldValuesList extends \yii\db\ActiveRecord
{
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
        return 'block_ready_field_values_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'value'], 'required'],
            [['field_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['field_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['value'], 'string', 'max' => 128],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlockReadyField::class, 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new BlockFieldValuesList)->attributeLabels();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(BlockReadyField::class, ['id' => 'field_id']);
    }


}
