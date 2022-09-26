<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use common\models\Catalog;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\web\JsExpression;
use \common\components\helpers\DepartmentHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Department */
/* @var $oid int */
/* @var $otype string */

$this->title = 'Департаменты';
$this->params['breadcrumbs'][] = ['label' => 'Структура', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_TREE;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT);

$departmentTreeID = 'department-tree';

$treeSettings = [
    'view' => [
        'showLine' => true,
        'selectedMulti' => false,
        'dblClickExpand' => false,
        'fontCss' => new JsExpression("getFont"),
        'nameIsHTML' => true,
//        'addHoverDom' => new JsExpression("app.addHoverDom"),
//        'removeHoverDom' => new JsExpression("app.removeHoverDom"),
    ],
    'edit' => [
        'enable' => true,
        'showRemoveBtn' => new JsExpression("app.showRemoveBtn"),
        'showRenameBtn' => false,
        'removeTitle' => 'Удаление',
    ],
    'callback' => [
        'beforeRemove' => new JsExpression("app.beforeRemove"),
        'onRemove' => new JsExpression("app.onRemove"),
        'beforeClick' => new JsExpression("app.onBeforeClickTreeNode"),
        'onClick' => new JsExpression("app.onClickTreeNode"),
        'beforeDrag' => new JsExpression("app.beforeDrag"),
    ],
];

$zNodes = \common\components\helpers\DepartmentHelper::getDepartmentsTreeData($model, $oid, $otype);
$zNodes = \common\components\helpers\DepartmentHelper::clearArrayKeys($zNodes);
//echo '<pre>';
//\yii\helpers\VarDumper::dump($zNodes);
//print_r($zNodes);
//exit;

$this->registerJsVar('departmentTreeSettings', $treeSettings, $this::POS_END);
$this->registerJsVar('departmentTreeNodes', $zNodes, $this::POS_END);

$js = '
    var curMenu = null, zTree_Menu = null, oid = '.$oid.', otype = "'.$otype.'";
    jQuery.fn.zTree.init(jQuery("#'.$departmentTreeID.'"), departmentTreeSettings, departmentTreeNodes);
    app.departmentTreeID = "'.$departmentTreeID.'";
    app.treeTypes.department = "'.DepartmentHelper::TYPE_DEPARTMENT.'";
    app.treeTypes.menu = "'.DepartmentHelper::TYPE_MENU.'";
    app.treeTypes.tag = "'.DepartmentHelper::TYPE_MENU_TAG.'";

    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }

    if (!!oid && !!otype) {
        zTree_Menu = jQuery.fn.zTree.getZTreeObj("'.$departmentTreeID.'");
        curMenu = app.getCurrentTreeNode2(zTree_Menu.getNodes(), oid, otype);
        if (!!curMenu) {
            zTree_Menu.selectNode(curMenu);
            //console.log("selected "+curMenu);
            jQuery("#" + curMenu.tId + "_a").click();
        }
    }
';
$this->registerJs($js, $this::POS_READY);
$js = '
    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }
';
$this->registerJs($js, $this::POS_HEAD);

$widgetID = 'dialog-department-tree-'.time();
echo Html::style('#'.$widgetID.' div.modal-dialog {width: 70%;}');
echo Html::style('#'.$widgetID.' div.bootstrap-dialog-message {height: 500px; overflow-y: auto;}');

echo Dialog::widget([
    'id' => $widgetID,
    'libName' => 'krajeeDialogDepartmentsTreeView',
    'options' => [
        'size' => Dialog::SIZE_NORMAL,
        'type' => Dialog::TYPE_SUCCESS,
        'title' => 'Дерево посадочных страниц',
        'nl2br' => false,
        'buttons' => [
            [
                'id' => 'cust-cancel-btn',
                'label' => 'Отмена',
                'cssClass' => 'btn-outline-secondary',
                'hotkey' => 'C',
                'action' => new JsExpression("function(dialog) {
                    return dialog.close();
                }")
            ],
            [
                'id' => 'cust-submit-btn',
                'label' => 'ОК',
                'cssClass' => 'btn-success',
                'hotkey' => 'S',
                'action' => new JsExpression("function(dialog) {
                    return dialog.close();
                }")
            ],
        ],
    ],
]);


$widgetAnalizeID = 'dialog-department-analize-'.time();
echo Html::style('#'.$widgetAnalizeID.' div.modal-dialog {width: 70%;}');
echo Html::style('#'.$widgetAnalizeID.' div.bootstrap-dialog-message {height: 500px; overflow-y: auto;}');

echo Dialog::widget([
    'id' => $widgetAnalizeID,
    'libName' => 'krajeeDialogDepartmentsAnalizeView',
    'options' => [
        'size' => Dialog::SIZE_NORMAL,
        'type' => Dialog::TYPE_SUCCESS,
        'title' => 'Анализ структуры',
        'nl2br' => false,
        'buttons' => [
            [
                'id' => 'cust-cancel-btn',
                'label' => 'Отмена',
                'cssClass' => 'btn-outline-secondary',
                'hotkey' => 'C',
                'action' => new JsExpression("function(dialog) {
                    return dialog.close();
                }")
            ],
            [
                'id' => 'cust-submit-btn',
                'label' => 'ОК',
                'cssClass' => 'btn-success',
                'hotkey' => 'S',
                'action' => new JsExpression("function(dialog) {
                    jQuery('#form-department-analize').submit();
                    return dialog.close();
                }")
            ],
        ],
    ],
]);


?>
<div class="department-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> Добавить департамент', ['/department/department/create'], ['class' => 'btn btn-success',]) ?>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_STRUCTURES.'"></span> Дерево посадочных страниц', ['/department/department/tree'], ['class' => 'departments-tree-view-btn btn btn-info',]) ?>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ANALIZE.'"></span> Анализ структуры', ['/department/department/analize'], ['class' => 'departments-analize-view-btn btn btn-warning',]) ?>
    </p>
</div>
<div class="row">
    <div class="col-md-5">
        <ul id="<?= $departmentTreeID ?>" class="ztree" style="overflow-y:auto;"></ul>
    </div>
    <div class="col-md-7" id="department-tree-content"><i class="fas fa-info-circle"></i> Выберите один из пунктов дерева</div>
</div>
