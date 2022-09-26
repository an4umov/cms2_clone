<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "block_ready_field".
 *
 * @property int $id
 * @property int $block_id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BlockReady $block
 * @property BlockReadyFieldList[] $blockReadyFieldLists
 * @property BlockReadyFieldValuesList[] $blockReadyFieldValuesLists
 */
class BlockReadyField extends \yii\db\ActiveRecord
{
    public $sort_list;
    public $list;
    public $values_list;

    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        return (new BlockField())->getTypeOptions();
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

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeClass(string $type) : string
    {
        return $this->getTypeClasses()[$type];
    }

    /**
     * @return array
     */
    public function getTypeClasses() : array
    {
        return (new BlockField())->getTypeClasses();
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeIcon(string $type) : string
    {
        return $this->getTypeIcons()[$type];
    }

    /**
     * @return array
     */
    public function getTypeIcons() : array
    {
        return (new BlockField())->getTypeIcons();
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
        return 'block_ready_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_id', 'name'], 'required'],
            [['block_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['block_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            ['type', 'in', 'range' => BlockField::TYPES,],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 255],
            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlockReady::class, 'targetAttribute' => ['block_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return (new BlockField())->attributeLabels();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(BlockReady::class, ['id' => 'block_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockReadyFieldLists()
    {
        return $this->hasMany(BlockReadyFieldList::class, ['field_id' => 'id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockReadyFieldValuesLists()
    {
        return $this->hasMany(BlockReadyFieldValuesList::class, ['field_id' => 'id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockFieldLists()
    {
        return $this->hasMany(BlockReadyFieldList::class, ['field_id' => 'id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockFieldValuesLists()
    {
        return $this->hasMany(BlockReadyFieldValuesList::class, ['field_id' => 'id',]);
    }

    /**
     * @return array
     */
    public function getBlockFieldValuesOptions()
    {
        $rows = $this->getBlockFieldValuesLists()->all();

        return ArrayHelper::map($rows, 'id', 'value');
    }
}
