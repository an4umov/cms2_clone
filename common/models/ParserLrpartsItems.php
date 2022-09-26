<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "parser_lrparts_items".
 *
 * @property int $id
 * @property int $rubric_id
 * @property string $position
 * @property string $name
 * @property string $code
 * @property string $url
 * @property string $path
 * @property string $catalog_codes
 * @property boolean $is_active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ParserLrpartsRubrics $rubric
 * @property Articles $article
 */
class ParserLrpartsItems extends \yii\db\ActiveRecord
{
    public $article_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser_lrparts_items';
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
            [['rubric_id', 'position', 'name', 'code',], 'required'],
            [['rubric_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['rubric_id', 'created_at', 'updated_at'], 'integer'],
            [['path'], 'string'],
            [['position', 'name', 'url'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 25],
            [['is_active',], 'boolean'],
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
            'position' => 'Позиция',
            'name' => 'Название',
            'code' => 'Код',
            'url' => 'URL',
            'path' => 'Старый путь',
            'catalog_codes' => 'Сопутствующие разделы каталога LR.RU',
            'is_active' => 'Активен',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
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
    public function getArticle()
    {
        return $this->hasOne(Articles::class, [Articles::tableName().'.number' => ParserLrpartsItems::tableName().'.code',]);

        //$query->leftJoin(Articles::tableName(), 'lower('.ParserLrpartsItems::tableName().'.code) = lower('.Articles::tableName().'.number)');
    }

    /**
     * @return string
     */
    public function getItemName() : string
    {
        return !empty($this->article_name) ? $this->article_name : $this->name;
    }

    /**
     * @return string
     */
    public function getItemName2() : string
    {
        return !empty($this->article) ? $this->article->name : $this->name;
    }
}
