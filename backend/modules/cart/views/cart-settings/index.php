<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\CartSettings */

$this->title = 'Настройка корзины';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => '/'.MenuHelper::FIRST_MENU_SETTINGS,];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_CART_SETTINGS;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_CART);

$treeID = 'cart-settings';

$treeSettings = [
    'view' => [
        'showLine' => true,
        'selectedMulti' => false,
        'dblClickExpand' => false,
        'fontCss' => new JsExpression("getFont"),
        'nameIsHTML' => true,
    ],
    'edit' => [
        'enable' => false,
    ],
    'callback' => [
        'beforeClick' => new JsExpression("app.onBeforeClickTreeNode"),
        'onClick' => new JsExpression("app.onClickTreeNode"),
        'beforeDrag' => new JsExpression("app.beforeDrag"),
    ],
];

$zNodes = \common\components\helpers\CartHelper::getCartSettingTreeData($model);

//echo '<pre>';
//\yii\helpers\VarDumper::dump($zNodes);
//print_r($zNodes);
//exit;

$this->registerJsVar('lrpartsTreeSettings', $treeSettings, $this::POS_END);
$this->registerJsVar('lrpartsTreeNodes', $zNodes, $this::POS_END);

$js = '
    var curMenu = null, zTree_Menu = null;
    jQuery.fn.zTree.init(jQuery("#'.$treeID.'"), lrpartsTreeSettings, lrpartsTreeNodes);
    app.cartSettingsTreeID = "'.$treeID.'";

    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }

';
$this->registerJs($js, $this::POS_READY);

if (!empty($model)) {
    $js = 'app.getTreeAjaxContent("'.'/'.MenuHelper::FIRST_MENU_CART.'/'.MenuHelper::SECOND_MENU_SETTINGS_CART_SETTINGS.'/view?id='.$model->id.'", {});';

    $this->registerJs($js, $this::POS_READY);
}

$js = '
    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }
';
$this->registerJs($js, $this::POS_HEAD);
?>
<div class="row">
    <div class="col-md-3">
        <ul id="<?= $treeID ?>" class="ztree" style="overflow-y:auto;"></ul>
    </div>
    <div class="col-md-9" id="department-tree-content"><i class="fas fa-info-circle"></i> Выберите конечную рубрику для просмотра товаров</div>
</div>
