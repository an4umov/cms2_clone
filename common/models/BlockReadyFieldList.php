<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "block_ready_field_list".
 *
 * @property int $id
 * @property int $field_id
 * @property string $name
 * @property string $type
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BlockReadyField $field
 */
class BlockReadyFieldList extends \yii\db\ActiveRecord
{

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeClass(string $type) : string
    {
        return(new BlockFieldList())->getTypeClass($type);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeIcon(string $type) : string
    {
        return (new BlockFieldList())->getTypeIcon($type);
    }

    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        return (new BlockFieldList())->getTypeOptions();
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        return $this->getTypeOptions()[$type];
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
    public static function tableName()
    {
        return 'block_ready_field_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_id', 'name'], 'required'],
            [['field_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['field_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string'],
            ['type', 'in', 'range' => BlockFieldList::TYPES,],
            [['name'], 'string', 'max' => 128],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlockReadyField::class, 'targetAttribute' => ['field_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new BlockFieldList())->attributeLabels();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(BlockReadyField::class, ['id' => 'field_id',]);
    }
}
