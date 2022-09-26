<?php
//
//namespace backend\models;
//
//use backend\models\Tree;
//use common\models\Material;
//use creocoder\nestedsets\NestedSetsBehavior;
//use kartik\tree\TreeView;
//use Yii;
//use yii\base\Module;
//use yii\behaviors\SluggableBehavior;
//use yii\behaviors\TimestampBehavior;
//use yii\helpers\ArrayHelper;
//use yii\helpers\VarDumper;
//
///**
// * This is the model class for table "menu".
// *
// * @property int $id
// * @property string $title
// * @property string $alias
// * @property int $parent_id
// * @property int $status
// * @property int $created_at
// * @property int $updated_at
// *
// * @property MenuMaterial[] $menuMaterials
// * @property Material[] $materials
// */
//class Menu extends Tree
//{
//    const SOURCE = 'menu';
//
//    /**
//     * {@inheritdoc}
//     */
//    public static function tableName()
//    {
//        return 'menu';
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function rules()
//    {
//        return ArrayHelper::merge(
//            parent::rules(),
//            [
//                [['title', 'alias'], 'required'],
//                [['parent_id', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
//                [['parent_id', 'status', 'created_at', 'updated_at'], 'integer'],
//                [['title', 'alias'], 'string', 'max' => 256],
//                [['alias'], 'unique'],
//            ]);
//    }
//
//    /**
//     * @return array
//     */
//    public function behaviors()
//    {
//        try {
//            /** @var Module $module */
//            $module = TreeView::module();
//            $settings = ['class' => NestedSetsBehavior::class] + $module->treeStructure;
//            $treeBehaviors = empty($module->treeBehaviorName) ? [$settings] : [$module->treeBehaviorName => $settings];
//        } catch(\yii\base\InvalidConfigException $e) {
//            $treeBehaviors = [];
//        }
//
//        return ArrayHelper::merge( $treeBehaviors, [
//            [ 'class' => TimestampBehavior::class ],
//            [
//                'class' => SluggableBehavior::class,
//                'attribute' => 'title',
//                'slugAttribute' => 'alias',
//            ],
//            'slug' => [
//                'class' => 'common\behaviors\Slug',
//                'in_attribute' => 'title',
//                'out_attribute' => 'alias',
//                'translit' => true
//            ],
//        ]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'title' => 'Заголовок',
//            'alias' => 'Псевдоним',
//            'parent_id' => 'Родитель',
//            'status' => 'Опубликован',
//            'created_at' => 'Создан',
//            'updated_at' => 'Обновлен',
//            'name' => 'Имя',
//            'icon' => 'Иконка'
//        ];
//    }
//
//    /**
//     * @return \yii\db\ActiveQuery
//     */
//    public function getMaterials()
//    {
//        return $this->hasMany(Material::className(), ['id' => 'material_id'])->viaTable('menu_material', ['menu_id' => 'id']);
//    }
//
//    /**
//     * {@inheritdoc}
//     * @return \common\models\query\MenuQuery the active query used by this AR class.
//     */
//    public static function find()
//    {
//        return new \common\models\query\MenuQuery(get_called_class());
//    }
//
//    /**
//     * @return bool
//     */
//    public function beforeValidate()
//    {
//        if (!empty($this->name)) {
//            $this->title = $this->name;
//        }
//        if (!empty($this->root) && $this->root !== $this->id) {
//            $this->parent_id = $this->root;
//        }
//        return parent::beforeValidate();
//    }
//
//
//}
