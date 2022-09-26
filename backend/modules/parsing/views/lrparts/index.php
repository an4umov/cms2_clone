<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'LrParts.ru';
$this->params['breadcrumbs'][] = ['label' => 'Парсинг', 'url' => ['/'.MenuHelper::FIRST_MENU_PARSING,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_PARSING;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_PARSING_LRPARTS;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_PARSING);

$treeID = 'parsing-lrparts';

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
        'enable' => false,
    ],
    'callback' => [
        'beforeClick' => new JsExpression("app.onBeforeClickTreeNode"),
        'onClick' => new JsExpression("app.onClickTreeNode"),
        'beforeDrag' => new JsExpression("app.beforeDrag"),
    ],
];

$zNodes = \common\components\helpers\ParserHelper::getLrpartsTreeData();
//$zNodes = [['name' => 'Запчасти', 'id' => 0, 'url' => '', 'open' => true, 'type' => DepartmentHelper::TYPE_ROOT, Catalog::TREE_ITEM_CHILDREN => [],],];
//$zNodes = \common\components\helpers\DepartmentHelper::clearArrayKeys($zNodes);
//echo '<pre>';
//\yii\helpers\VarDumper::dump($zNodes);
//print_r($zNodes);
//exit;

$this->registerJsVar('lrpartsTreeSettings', $treeSettings, $this::POS_END);
$this->registerJsVar('lrpartsTreeNodes', $zNodes, $this::POS_END);

$js = '
    var curMenu = null, zTree_Menu = null;
    jQuery.fn.zTree.init(jQuery("#'.$treeID.'"), lrpartsTreeSettings, lrpartsTreeNodes);
    app.lrpartsTreeID = "'.$treeID.'";

    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }

';
$this->registerJs($js, $this::POS_READY);
$js = '
    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }
';
$this->registerJs($js, $this::POS_HEAD);

$widgetItemUpdateID = 'dialog-lrparts-item-'.time();
echo Html::style('#'.$widgetItemUpdateID.' div.modal-dialog {width: 40%;}');
echo Html::style('#'.$widgetItemUpdateID.' div.bootstrap-dialog-message {height: 380px; overflow-y: auto;}');

$widgetItemAddID = 'dialog-lrparts-item-add-'.time();
echo Html::style('#'.$widgetItemAddID.' div.modal-dialog {width: 40%;}');
echo Html::style('#'.$widgetItemAddID.' div.bootstrap-dialog-message {height: 380px; overflow-y: auto;}');

echo Dialog::widget([
    'id' => $widgetItemUpdateID,
    'libName' => 'krajeeDialogLrPartsItemUpdate',
    'options' => [
        'size' => Dialog::SIZE_NORMAL,
        'type' => Dialog::TYPE_SUCCESS,
        'title' => 'Товар',
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
                    if (itemForm.valid()) {                
                        jQuery.when( app.sendAjaxForm('form-lrparts-item') ).then(function( response, textStatus, jqXHR ) {
                            if (!!response.ok) {
                                app.addNotification('Товар сохранен');
                                app.getTreeAjaxContent(itemListUrl, {});
                                
                                return dialog.close();
                            } else {
                                if (!!response.message) {
                                    app.addNotification(response.message);
                                }
                            }
                        });
                    }                
                }")
            ],
        ],
    ],
]);

echo Dialog::widget([
    'id' => $widgetItemAddID,
    'libName' => 'krajeeDialogLrPartsItemAdd',
    'options' => [
        'size' => Dialog::SIZE_NORMAL,
        'type' => Dialog::TYPE_SUCCESS,
        'title' => 'Добавление товара',
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
                    if (itemForm.valid()) {                
                        jQuery.when( app.sendAjaxForm('form-lrparts-items-add') ).then(function( response, textStatus, jqXHR ) {
                            if (!!response.ok) {
                                app.addNotification('Товар добавлен');
                                app.getTreeAjaxContent(itemListUrl, {});
                                
                                return dialog.close();
                            } else {
                                if (!!response.message) {
                                    app.addNotification(response.message);
                                }
                            }
                        });
                    }                
                }")
            ],
        ],
    ],
]);
?>
<div class="row">
    <div class="col-md-5">
        <?php $form = ActiveForm::begin([
            'id' => 'form-lrparts-replace',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'method' => 'post',
            'action' => Url::to(['/parsing/lrparts/replace',]),
            'options' => ['class' => 'form-inline',],
        ]); ?>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Поиск" name="search">
        </div>
        <button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
        <a class="btn btn-info" href="/parsing/lrparts/settings" role="button" title="Настройки"><i class="fa fa-cog"></i></a>
        <?php ActiveForm::end(); ?>

        <ul id="<?= $treeID ?>" class="ztree" style="overflow-y:auto;"></ul>
    </div>
    <div class="col-md-7" id="department-tree-content"><i class="fas fa-info-circle"></i> Выберите конечную рубрику для просмотра товаров</div>
</div>
