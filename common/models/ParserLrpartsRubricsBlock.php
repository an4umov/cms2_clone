<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "parser_lrparts_rubrics_block".
 *
 * @property int $id
 * @property int $rubric_id
 * @property int $block_id
 * @property int $sort
 * @property bool $is_active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Block $block
 * @property ParserLrpartsRubrics $rubric
 * @property ParserLrpartsRubricsBlockField $rubricsBlockField
 */
class ParserLrpartsRubricsBlock extends \yii\db\ActiveRecord
{
    public $type;

    public function init()
    {
        parent::init();

        $this->type = ContentBlock::TYPE_BLOCK;
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
        return 'parser_lrparts_rubrics_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rubric_id', 'block_id', 'sort'], 'required'],
            [['rubric_id', 'block_id', 'sort', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['rubric_id', 'block_id', 'sort', 'created_at', 'updated_at'], 'integer'],
            [['is_active'], 'boolean'],
//            [['block_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::class, 'targetAttribute' => ['block_id' => 'id']],
            [['rubric_id'], 'exist', 'skipOnError' => true, 'targetClass' => ParserLrpartsRubrics::class, 'targetAttribute' => ['rubric_id' => 'id']],
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
            'block_id' => 'Блок',
            'sort' => 'Сортировка',
            'is_active' => 'Активен',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::class, ['id' => 'block_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubric()
    {
        return $this->hasOne(ParserLrpartsRubrics::class, ['id' => 'rubric_id',]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubricsBlockField()
    {
        return $this->hasOne(ParserLrpartsRubricsBlockField::class, ['parser_lrparts_rubrics_block_id' => 'id',])->where([ParserLrpartsRubricsBlockField::tableName().'.deleted_at' => null,]);
    }

    /**
     * @return false|int|mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete()
    {
        if ($field = $this->getRubricsBlockField()->one()) {
            $field->delete();
        }

        return parent::delete();
    }
}
