<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "parser_lrparts_rubrics_block_field".
 *
 * @property int $id
 * @property int $parser_lrparts_rubrics_block_id
 * @property string $data JSON
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 *
 * @property Block $parserLrpartsRubricsBlock
 */
class ParserLrpartsRubricsBlockField extends \yii\db\ActiveRecord
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
        return 'parser_lrparts_rubrics_block_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parser_lrparts_rubrics_block_id', 'data'], 'required'],
            [['parser_lrparts_rubrics_block_id', 'created_at', 'updated_at', 'deleted_at'], 'default', 'value' => null],
            [['parser_lrparts_rubrics_block_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['data'], 'string'],
            [['parser_lrparts_rubrics_block_id'], 'exist', 'skipOnError' => true, 'targetClass' => Block::class, 'targetAttribute' => ['parser_lrparts_rubrics_block_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parser_lrparts_rubrics_block_id' => 'Блок',
            'data' => 'Данные полей',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'deleted_at' => 'Удалено',
        ];
    }

    /**
     * @return array
     */
    public function getData() : array
    {
        return !empty($this->data) ? Json::decode($this->data) : [];
    }

    /**
     * @return string
     */
    public function getRawData() : string
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = Json::encode($data);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParserLrpartsRubricsBlock()
    {
        return $this->hasOne(Block::class, ['id' => 'parser_lrparts_rubrics_block_id',]);
    }
}
