<?php

namespace common\models;


use backend\models\Tree;
use creocoder\nestedsets\NestedSetsBehavior;
use kartik\tree\TreeView;
use yii\base\Module;
use yii\helpers\ArrayHelper;

class TagCategory extends Tree
{
    public static function tableName()
    {
        return 'tag_categories';
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [

        ]);
    }

    /**
     * @return array
     */
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

        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('tag_tag_categories', ['tag_categories_id' => 'id']);
    }
}