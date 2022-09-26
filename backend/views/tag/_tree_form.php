<?php

use backend\models\TagSelectParentForm;
use common\models\Tag;
use yii\base\View;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Tag $node
 */

$tagParentForm = new TagSelectParentForm();

//\common\models\Tag::find()->addOrderBy('root, lft')->all()
$list = ArrayHelper::map(Tag::find()->where(['active' => true, 'visible' => true])->addOrderBy('root, lft')->all(), 'id', 'name');

$parent = $node->parents(1)->one();
$parentId = 0;
if (!is_null($parent)) {
    $parentId = $parent->id;
}

//\yii\helpers\VarDumper::dump([$node, $parent], 4, 1);exit;

$form = ActiveForm::begin();

    echo $form->field($tagParentForm, 'parent_id')
        ->dropDownList($list, [
            'prompt' => 'Выберите родителя',
            'options' => [$parentId => [ 'selected' => true ],],
            'id' => 'select_root',
        ]);

    echo $form->field($node, 'sort')->input('number');
ActiveForm::end();

//
//if ( ! $node->isNewRecord ) {
//    $dataProvider = new \yii\data\ActiveDataProvider([
//        'query' => $node->children()->all(),
//        'pagination' => [
//            'pageSize' => 20,
//        ],
//    ]);
//
//    echo $this->render('_tag_grid', [
//        'dataProvider' => $dataProvider,
//        'parentId' => $node->id
//    ]);
//}


