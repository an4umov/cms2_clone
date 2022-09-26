<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cat_recomend".
 *
 * @property int $id
 * @property string $cat
 * @property string $recomend_cat
 * @property int $created_at
 * @property int $updated_at
 */
class CatRecomend extends \yii\db\ActiveRecord
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
        return 'cat_recomend';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat', 'recomend_cat'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['cat', 'recomend_cat'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat' => 'Раздела магазина для которого рекомендуется раздел',
            'recomend_cat' => 'Раздела магазина, который рекомендуется',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
