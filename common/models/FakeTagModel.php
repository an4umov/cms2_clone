<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 * Класс модель для тегов, дублирует класс Tag, но не зависит от nested set поведения,
 * это не мейшает ей использоваться в стандартных CRUD операциях.
 * Нужен для расширяющих операций на деревом
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 * @property int $type
 * @property int $root
 * @property int $lft
 * @property int $rgt
 * @property int $lvl
 * @property string $icon
 * @property int $icon_type
 * @property bool $active
 * @property bool $selected
 * @property bool $disabled
 * @property bool $readonly
 * @property bool $visible
 * @property bool $collapsed
 * @property bool $movable_u
 * @property bool $movable_d
 * @property bool $movable_l
 * @property bool $movable_r
 * @property bool $removable
 * @property bool $removable_all
 * @property bool $child_allowed
 */
class FakeTagModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'type', 'root', 'lft', 'rgt', 'lvl', 'icon_type'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'type', 'root', 'lft', 'rgt', 'lvl', 'icon_type'], 'integer'],
            [['active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all', 'child_allowed'], 'boolean'],
            [['name'], 'string', 'max' => 256],
            [['icon'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'root' => 'Root',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'lvl' => 'Lvl',
            'icon' => 'Icon',
            'icon_type' => 'Icon Type',
            'active' => 'Active',
            'selected' => 'Selected',
            'disabled' => 'Disabled',
            'readonly' => 'Readonly',
            'visible' => 'Visible',
            'collapsed' => 'Collapsed',
            'movable_u' => 'Movable U',
            'movable_d' => 'Movable D',
            'movable_l' => 'Movable L',
            'movable_r' => 'Movable R',
            'removable' => 'Removable',
            'removable_all' => 'Removable All',
            'child_allowed' => 'Child Allowed',
        ];
    }
}
