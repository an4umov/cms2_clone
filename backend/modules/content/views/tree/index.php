<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use common\models\ContentTree;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\CartSettings */

$this->title = 'Дерево контента';
$this->params['breadcrumbs'][] = ['label' => 'Контент', 'url' => ['/'.MenuHelper::FIRST_MENU_CONTENT,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_CONTENT;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_CONTENT_TREE;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT_TREE);

$treeID = 'content-tree';

$treeSettings = [
    'view' => [
        'showLine' => true,
        'selectedMulti' => false,
        'dblClickExpand' => false,
        'fontCss' => new JsExpression("getFont"),
        'nameIsHTML' => true,
        'addHoverDom' => new JsExpression("app.addHoverDomContentTree"),
        'removeHoverDom' => new JsExpression("app.removeHoverDomContentTree"),
    ],
    'edit' => [
        'enable' => true,
        'showRemoveBtn' => new JsExpression("app.showRemoveBtnContentTree"),
        'showRenameBtn' => new JsExpression("app.showRenameBtnContentTree"),
        'removeTitle' => 'Удалить папку',
        'drag' => [
            'autoExpandTrigger' => true,
            'prev' => new JsExpression("app.dropPrevContentTree"),
            'inner' => new JsExpression("app.dropInnerContentTree"),
            'next' => new JsExpression("app.dropNextContentTree")
        ],
    ],
    'callback' => [
        'beforeClick' => new JsExpression("app.onBeforeClickTreeNode"),
        'onClick' => new JsExpression("app.onClickTreeNode"),

        'beforeRemove' => new JsExpression("app.beforeRemoveContentTree"),
        'onRemove' => new JsExpression("app.onRemoveContentTree"),

        'beforeDrag' => new JsExpression("app.beforeDragContentTree"),
        'beforeDrop' => new JsExpression("app.beforeDropContentTree"),
        'onDrop' => new JsExpression("app.onDropContentTree"),
    ],
];

$zNodes = \common\components\helpers\ContentHelper::getContentTreeData($model);

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
    app.contentTreeID = "'.$treeID.'";
    app.contentTreeTypeFolder = "'.ContentTree::TREE_TYPE_FOLDER.'";
    app.contentTreeTypeContent = "'.ContentTree::TREE_TYPE_CONTENT.'";
    app.contentTreeNewFolder = "'.ContentTree::NEW_FOLDER_NAME.'";
    app.contentTreeFolderFont = '.new JsExpression(ContentTree::FOLDER_FONT).';

    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }
';
$this->registerJs($js, $this::POS_READY);

if (!empty($model)) {
    $js = '
        var zTree = jQuery.fn.zTree.getZTreeObj(app.contentTreeID);
        var nodes = zTree.getNodesByParam("type", app.contentTreeTypeFolder, null);
        
        for(const node of nodes) {
            if (node.id === '.$model->id.') {
                zTree.selectNode(node);
            }
        }        
        
        app.getTreeAjaxContent("'.'/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/folder?id='.$model->id.'", {});
    ';

    $this->registerJs($js, $this::POS_READY);
}

$js = '
    function getFont(treeId, node) {
        return node.font ? node.font : {};
    }
';
$this->registerJs($js, $this::POS_HEAD);
$this->registerCss('.ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}');
?>
<div class="row">
    <div class="col-md-5">
        <ul id="<?= $treeID ?>" class="ztree" style="overflow-y:auto;"></ul>
    </div>
    <div class="col-md-7" id="department-tree-content"><i class="fas fa-info-circle"></i> Выберите виртуальную папку или контент</div>
</div>
<?
    //$hash = Yii::$app->getSecurity()->generatePasswordHash('4dgnQEVTPe7KJWQZ');
    //echo $hash;
?>