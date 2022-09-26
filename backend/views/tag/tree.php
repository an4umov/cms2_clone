<?php

use common\models\Tag;
use kartik\tree\Module;
use kartik\tree\TreeView;
use kartik\tree\TreeViewInput;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="box">
        <div class="box-body">
            <?php
            echo TreeView::widget([
                'id' => 'menu_tree',
                'query' => Tag::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => 'Store'],
                'rootOptions' => ['label' => '<span class="text-primary">' . $this->title . '</span>'],
                'topRootAsHeading' => true,
                'fontAwesome' => true,
                'nodeView' => '@kvtree/views/_form',
                'nodeAddlViews' => [
                    Module::VIEW_PART_5 => '@backend/views/tag/_tree_form',
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
                'query' => Tag::find()->addOrderBy('root, lft'),
                'headingOptions' => ['label' => $this->title],
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

            //            $this->registerJsFile('js/menu.js', [
            //                'depends' => ['yii\web\JqueryAsset']
            //            ]);
            ?>

        </div>
    </div>

</div>
