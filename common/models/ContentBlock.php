<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "content_block".
 *
 * @property int $id
 * @property int $content_id
 * @property int $block_id
 * @property string $type
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 * @property bool $is_active
 *
 * @property Block $block
 * @property BlockReady $blockReady
 * @property Form $form
 * @property Content $content
 * @property ContentBlockField $contentBlockField
 */
class ContentBlock extends \yii\db\ActiveRecord
{
    const TYPE_BLOCK = 'block';
    const TYPE_BLOCK_READY = 'block_ready';
    const TYPE_FORM = 'form';

    const TYPES = [
        self::TYPE_BLOCK,
        self::TYPE_BLOCK_READY,
        self::TYPE_FORM,
    ];

    private $_types;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function init()
    {
        parent::init();

        $this->_types = [
            self::TYPE_BLOCK => 'Блок',
            self::TYPE_BLOCK_READY => 'Готовый блок',
            self::TYPE_FORM => 'Форма',
        ];
    }

    /**
     * @return array
     */
    public function getTypeOptions() : array
    {
        return $this->_types;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getTypeTitle(string $type) : string
    {
        return $this->_types[$type];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'block_id', 'sort'], 'required'],
            [['content_id', 'block_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['content_id', 'block_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string'],
            ['type', 'in', 'range' => self::TYPES,],
            [['is_active'], 'boolean',],
            [['is_active',], 'default', 'value' => true,],
//            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::class, 'targetAttribute' => ['block_id' => 'id',],],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::class, 'targetAttribute' => ['content_id' => 'id',],],
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
            'block_id' => 'Блок',
            'sort' => 'Сортировка',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'type' => 'Тип',
            'is_active' => 'Активен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        if ($this->type === self::TYPE_BLOCK) {
            return $this->hasOne(Block::class, ['id' => 'block_id',]);
        }

        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlockReady()
    {
        if ($this->type === self::TYPE_BLOCK_READY) {
            return $this->hasOne(BlockReady::class, ['id' => 'block_id',]);
        }

        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForm()
    {
        if ($this->type === self::TYPE_FORM) {
            return $this->hasOne(Form::class, ['id' => 'block_id',]);
        }

        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::class, ['id' => 'content_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentBlockField()
    {
        return $this->hasOne(ContentBlockField::class, ['content_block_id' => 'id',])->where([ContentBlockField::tableName().'.deleted_at' => null,]);
    }

    /**
     * @return false|int|mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        if ($field = $this->getContentBlockField()->one()) {
            $field->delete();
        }

        return parent::delete();
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return !$this->is_active ? 'danger' : 'default';
    }
}
