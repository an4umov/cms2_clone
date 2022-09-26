<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\tree\TreeViewInput;
use kartik\tree\TreeView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пункты меню';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php
        echo TreeView::widget([
            'id' => 'menu_tree',
            'query' => \common\models\Menu::find()->addOrderBy('root, lft'),
            'headingOptions' => ['label' => 'Store'],
            'rootOptions' => ['label' => '<span class="text-primary">Меню</span>'],
            'topRootAsHeading' => true,
            'fontAwesome' => true,
            'nodeView' => '@kvtree/views/_form',
            'nodeAddlViews' => [
                \kartik\tree\Module::VIEW_PART_5 => '@backend/views/menu/_tree_form',
            ],
            'iconEditSettings' => [
                'show' => 'none',
            ],
            'softDelete' => true,
            'cacheSettings' => ['enableCache' => true]
        ]);

        echo TreeViewInput::widget([
            // single query fetch to render the tree
            // use the Product model you have in the previous step
            'query' => \common\models\Menu::find()->addOrderBy('root, lft'),
            'headingOptions' => ['label' => 'Categories'],
            'name' => 'kv-product', // input name
            'value' => '1,2,3',     // values selected (comma separated for multiple select)
            'asDropdown' => true,   // will render the tree input widget as a dropdown.
            'multiple' => true,     // set to false if you do not need multiple selection
            'fontAwesome' => true,  // render font awesome icons
            'rootOptions' => [
                'label' => '<i class="fa fa-tree"></i>',  // custom root label
                'class' => 'text-success'
            ],
            //'options'=>['disabled' => true],
        ]);

        $this->registerJsFile('js/menu.js', [
                'depends' => ['yii\web\JqueryAsset']
        ]);
        ?>


        <?php Pjax::begin(); ?>

        <p>
            <? //= Html::a('Создать пункт меню', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php /* GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'title',
                'alias',
                'parent_id',
                'status',
                //'created_at',
                //'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); */ ?>
        <?php Pjax::end(); ?>
    </div>
</div>
