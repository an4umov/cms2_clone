<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "catalog_linktag_department".
 *
 * @property int $id
 * @property string $link_tag
 * @property string $code
 * @property string $department_code
 * @property int $created_at
 * @property int $updated_at
 */
class CatalogLinktagDepartment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalog_linktag_department';
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
            [['link_tag', 'code', 'department_code'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['link_tag'], 'string', 'max' => 100],
            [['code', 'department_code'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_tag' => 'Тег',
            'code' => 'Код раздела',
            'department_code' => 'Код департамента',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
}
