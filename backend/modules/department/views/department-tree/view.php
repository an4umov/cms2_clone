<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Department */
/* @var $oid int */
/* @var $otype string */

$this->title = 'Структура';
$this->params['breadcrumbs'][] = ['label' => 'Структуры', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES,],];
//$this->params['breadcrumbs'][] = ['label' => 'Департаменты', 'url' => ['/'.MenuHelper::FIRST_MENU_STRUCTURES.'/'.MenuHelper::SECOND_MENU_STRUCTURES_DEPARTMENT,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_STRUCTURES;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_STRUCTURES_TREE;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT_TREE);

$departmentTreeID = 'department-tree';

$treeSettings = [
    'view' => [
        'showLine' => true,
        'selectedMulti' => false,
        'dblClickExpand' => false,
        'fontCss' => new JsExpression("getFont"),
        'nameIsHTML' => true,
    ],
    'callback' => [
        'beforeClick' => new JsExpression("app.onBeforeClickTreeNode"),
        'onClick' => new JsExpression("app.onClickTreeNode"),
    ],
];

$zNodes = \common\components\helpers\DepartmentHelper::getDepartmentsTreeData($model, $oid, $otype);

$this->registerJsVar('departmentTreeSettings', $treeSettings, $this::POS_END);
$this->registerJsVar('departmentTreeNodes', \common\components\helpers\DepartmentHelper::clearArrayKeys($zNodes), $this::POS_END);

$js = '
    var curMenu = null, zTree_Menu = null, oid = '.$oid.', otype = "'.$otype.'";
    jQuery.fn.zTree.init(jQuery("#'.$departmentTreeID.'"), departmentTreeSettings, departmentTreeNodes);

    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }

    if (!!oid && !!otype) {
        zTree_Menu = jQuery.fn.zTree.getZTreeObj("'.$departmentTreeID.'");
        curMenu = app.getCurrentTreeNode(zTree_Menu.getNodes(), oid, otype);
        if (!!curMenu) {
            zTree_Menu.selectNode(curMenu);
            console.log("selected "+curMenu);
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
?>
<div class="department-index">
    <p>
        <?= Html::a('<span class="'.\backend\components\helpers\IconHelper::ICON_ADD.'"></span> '.'Добавить департамент', ['/department/department/create'], ['class' => 'btn btn-success',]) ?>
    </p>
</div>
<div class="row">
    <div class="col-md-5">
        <ul id="<?= $departmentTreeID ?>" class="ztree" style="overflow-y:auto;"></ul>
    </div>
    <div class="col-md-7" id="department-tree-content"><i class="fas fa-info-circle"></i> Выберите один из пунктов дерева</div>
</div>
