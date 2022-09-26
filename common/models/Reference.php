<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "reference".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $is_active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ReferenceValue[] $referenceValues
 */
class Reference extends \yii\db\ActiveRecord
{
    public $sort_list;

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
        return 'reference';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['is_active'], 'boolean'],
            [['is_active',], 'default', 'value' => true,],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['sort_list',], 'safe',],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'is_active' => 'Активен',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferenceValues()
    {
        return $this->hasMany(ReferenceValue::class, ['reference_id' => 'id',])->orderBy(['sort' => SORT_ASC,]);
    }

    /**
     * @return int
     */
    public function getReferenceValuesCount() : int
    {
        return $this->getReferenceValues()->count();
    }

    /**
     * @return array
     */
    public function getReferenceValuesOptions()
    {
        $rows = $this->getReferenceValues()->all();

        return ArrayHelper::map($rows, 'id', 'name');
    }

    /**
     * @return string
     */
    public function getSpecialClass() : string
    {
        return !$this->is_active ? 'danger' : 'default';
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $saved = parent::save($runValidation, $attributeNames);

        if ($saved && !empty($this->sort_list)) {
            $index = 1;
            $fields = [];
            foreach (explode(',', $this->sort_list) as $id) {
                $fields[$id] = $index++;
            }

            if ($fields) {
                $db = \Yii::$app->db;
                foreach ($fields as $id => $sortIndex) {
                    $db->createCommand()->update(
                        ReferenceValue::tableName(),
                        ['sort' => $sortIndex,],
                        ['id' => $id, 'reference_id' => $this->id,]
                    )->execute();
                }
            }
        }

        return $saved;
    }
}
