<?php

namespace common\models;


use backend\behaviors\TreeMoveBehavior;
use backend\models\TagSelectParentForm;
use backend\models\Tree;
use creocoder\nestedsets\NestedSetsBehavior;
use kartik\tree\TreeView;
use yii\base\Module;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Material[] $materials
 * @property int $type [smallint]
 * @property bool $child_allowed [boolean]
 * @property int $sort [smallint]
 */
class Tag extends Tree
{
    const TYPE_FOR_THEME = 1;
    const TYPE_FOR_CAR_BRAND = 2;
    const TYPE_WITHOUT_GROUP = 3;
    const MAX_LEVEL = 5;

    public $parent;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    public function behaviors()
    {
        try {
            /** @var Module $module */
            $module = TreeView::module();
            $settings = ['class' => NestedSetsBehavior::class] + $module->treeStructure;
            $treeBehaviors = empty($module->treeBehaviorName) ? [$settings] : [$module->treeBehaviorName => $settings];
        } catch(\yii\base\InvalidConfigException $e) {
            $treeBehaviors = [];
        }

        return ArrayHelper::merge( $treeBehaviors, [
            TimestampBehavior::class,
            TreeMoveBehavior::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'type', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 256],
            [['name'], 'unique'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тег',
            'type' => 'Тип',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'parent' => 'Выбрать родителя',
            'sort' => 'Сортировка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::class, ['id' => 'material_id'])->viaTable('tag_material', ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagCategories()
    {
        return $this->hasMany(TagCategory::class, ['id' => 'tag_categories_id'])->viaTable('tag_tag_categories', ['tag_id' => 'id']);
    }

    static $types = [
        self::TYPE_FOR_THEME => 'по тематике',
        self::TYPE_FOR_CAR_BRAND => 'по марке авто',
        self::TYPE_WITHOUT_GROUP => 'без группы'
    ];

    public function getTypes()
    {
        return self::$types;
    }

    public function typeName()
    {
        return self::$types[$this->type];
    }

    public function afterFind()
    {
        if (is_null($this->type)) {
            $this->type = self::TYPE_WITHOUT_GROUP;
        }
    }

//    public function beforeSave($insert)
//    {
//        $post = \Yii::$app->request->post();
//        $parentForm = new TagSelectParentForm();
//
//        if ($parentForm->load($post) && $parentForm->validate()) {
//            if ('' !== $parentForm->parent_id) {
////                VarDumper::dump($parentForm->errors, 3, 1);exit;
//                $newRoot = Tag::findOne($parentForm->parent_id);
//                //$newRoot->makeRoot();
//                $this->appendTo($newRoot);
//            }
//        }
//
//        return parent::beforeSave($insert);
//    }
}
