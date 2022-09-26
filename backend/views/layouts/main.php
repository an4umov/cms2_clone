<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$firstMenu = $this->params['firstMenu'] ?? MenuHelper::FIRST_MENU_HOME_PAGE;
$secondMenu = $this->params['secondMenu'] ?? '';
$thirdMenu = $this->params['thirdMenu'] ?? '';
$menuIcon = $this->params['menuIcon'] ?? '';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <?php $this->head() ?>
</head>
<body class="boxed-page">
<?php $this->beginBody() ?>

<div class="">
    <section id="container">
        <? $thirdMenuData = MenuHelper::thirdMenuLevel($secondMenu, $thirdMenu); ?>
        <? if ($thirdMenuData): ?>
        <header class="header3">
            <div class="navbar-header">
                <div class="horizontal-menu"><?= $thirdMenuData ?></div>
            </div>
        </header>
        <? endif; ?>
        <aside class="left-sidebar">
            <div class="left-sidebar__top">
                <!--logo start-->
                <a href="<?= Yii::$app->homeUrl ?>" class="logo"><img src="/img/logo-admin.svg" alt=""></a>
                <!--logo end-->
                <?= MenuHelper::rightMenu(); ?>
            </div>

            <?= MenuHelper::firstMenuLevel($firstMenu, $secondMenu); ?>
            <? $secondMenuData = MenuHelper::secondMenuLevel($firstMenu, $secondMenu); ?>
            <? if ($secondMenuData): ?>
                <!-- <?= $secondMenuData ?> -->
            <? endif; ?>
            <div class="left-sidebar__footer">
                <b>?</b> <a href="https://wiki.lr.ru/" target="_blank" class="footet-link">wiki.lr.ru</a> <a href="#" class="go-top"> <i class="fa fa-angle-up"></i></a>
            </div>
        </aside>
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <div class="breadcrumbs">
                    <?= Breadcrumbs::widget([
                        'homeLink' => [
                            'label' => 'Панель управления',
                            'url' => Yii::$app->homeUrl,
                        ],
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>
                </div>
                <?= \common\widgets\Alert::widget(['isBackend' => true, 'view' => $this,]) ?>
                <?php
                Yii::$app->session->removeAllFlashes();
                $js = '
    /*            let treeDataSource = new DataSourceTree({
                    data: [
                        { name: \'Theme<div class="tree-actions"><span class="fas fa-plus"></span> <span class="far fa-trash-alt"></span>\', type: \'folder\', additionalParameters: { id: \'F11\' } },
                        { 
                            name: \'Development<div class="tree-actions"><span class="fas fa-plus"> <span class="far fa-trash-alt"></span>\', type: \'folder\', additionalParameters: { id: \'F12\' },
                            data: [
                                { name: \'MEme<div class="tree-actions"><span class="fas fa-plus"></span> <span class="far fa-trash-alt"></span>\', type: \'folder\', additionalParameters: { id: \'F15\' } },
                                { name: \'<i class="fa fa-user"></i> ADMIN <div class="tree-actions"><span class="fas fa-plus"> <span class="far fa-trash-alt"></span>\', type: \'item\', additionalParameters: { id: \'I16\' } }
                            ] 
                        },
                        { name: \'<i class="fa fa-user"></i> User <div class="tree-actions"><span class="fas fa-plus"> <span class="far fa-trash-alt"></span>\', type: \'item\', additionalParameters: { id: \'I11\' } },
                        { name: \'<i class="fa fa-calendar"></i> Events <div class="tree-actions"><span class="fas fa-plus"> <span class="far fa-trash-alt"></span>\', type: \'item\', additionalParameters: { id: \'I12\' } },
                        { name: \'<i class="fas fa-cog"></i> Works <div class="tree-actions"><span class="fas fa-plus"> <span class="far fa-trash-alt"></span>\', type: \'item\', additionalParameters: { id: \'I13\' } }
                    ],
                    delay: 400
                });
                
                TreeView.init(treeDataSource);
             
                var folders = [
                    {
                        "name": "Engage<div class=\"tree-actions\"><span class=\"fas fa-plus\"></span>",
                        "type": "folder",
                        "dataAttributes": {
                            "id": "engage-folder"
                        },
                        "children": [
                            {
                                "name": "Abandoned Cart",
                                "type": "folder",
                                "children": [
                                    {
                                        "name": "Archive",
                                        "type": "folder"
                                    }
                                ]
                            },
                            {
                                "name": "Birthday",
                                "type": "folder"
                            },
                            {
                                "name": "Browse Retargeting",
                                "type": "folder"
                            },
                            {
                                "name": "Loyalty",
                                "type": "folder"
                            },
                            {
                                "name": "Newsletter",
                                "type": "item"
                            },
                            {
                                "name": "Post-Purchase",
                                "type": "item"
                            },
                            {
                                "name": "Promotional",
                                "type": "item"
                            },
                            {
                                "name": "Transactional",
                                "type": "folder",
                                "children": [
                                    {
                                        "name": "Archive",
                                        "type": "folder"
                                    }
                                ]
                            },
                            {
                                "name": "Wish List",
                                "type": "folder"
                            }
                        ]
                    },
                    {
                        "name": "Retain",
                        "type": "item"
                    }
                ];
                
                // initialize data source with data
                var treeDataSource = new StaticTreeDataSource(folders);
                
                // initialize the tree
                $("#myTree").tree({
                    dataSource: treeDataSource.getData,
                    multiSelect: false,
                    cacheItems: false,
                    folderSelect: true
                });
    */               
                
                
                
                ';


                //$this->registerJsVar('zNodes', \common\components\helpers\DepartmentHelper::getDepartmentTreeData(), $this::POS_HEAD);
                //$this->registerJs($js, $this::POS_READY);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">
                                <h4><?= $menuIcon ? $menuIcon.' ' : '' ?><?= $this->title ?></h4>
                            </header>
                            <div class="panel-body">
                                    <?= $content ?>
    <!--                            <div class="row">-->
    <!--                                <div class="col-md-2">-->
    <!--                                    <ul id="department-tree" class="ztree"></ul>-->


    <!--                                    <ul id="myTree" class="tree tree-folder-select" role="tree">-->
    <!--                                        <li class="tree-branch hide" data-template="treebranch" role="treeitem" aria-expanded="false">-->
    <!--                                            <div class="tree-branch-header">-->
    <!--                                                <button class="glyphicon icon-caret glyphicon-play"><span class="sr-only">Open</span></button>-->
    <!--                                                <button class="tree-branch-name">-->
    <!--                                                    <span class="glyphicon icon-folder glyphicon-folder-close"></span>-->
    <!--                                                    <span class="tree-label"></span>-->
    <!--                                                </button>-->
    <!--                                            </div>-->
    <!--                                            <ul class="tree-branch-children" role="group"></ul>-->
    <!--                                            <div class="tree-loader" role="alert">Loading...</div>-->
    <!--                                        </li>-->
    <!--                                        <li class="tree-item hide" data-template="treeitem" role="treeitem">-->
    <!--                                            <button class="tree-item-name">-->
    <!--                                                <span class="glyphicon icon-item fueluxicon-bullet"></span>-->
    <!--                                                <span class="tree-label"></span>-->
    <!--                                            </button>-->
    <!--                                        </li>-->
    <!--                                    </ul>-->


                                        <!--div id="department-tree" class="tree tree-solid-line">
                                            <div class = "tree-folder" style="display:none;">
                                                <div class="tree-folder-header">
                                                    <i class="fa fa-folder"></i>
                                                    <div class="tree-folder-name"></div>
                                                </div>
                                                <div class="tree-folder-content"></div>
                                                <div class="tree-loader" style="display:none"></div>
                                            </div>
                                            <div class="tree-item" style="display:none;">
                                                <i class="tree-dot"></i>
                                                <div class="tree-item-name"></div>
                                            </div>
                                        </div-->

    <!--                                </div>-->
    <!--                                <div class="col-md-10"></div>-->
    <!--                            </div>-->

                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </section>
    </section>
</div>
<!-- <footer class="site-footer">
    <div class="text-center"><?= date('Y') ?> © <a href="http://lr.ru" target="_blank" class="footet-link">lr.ru</a> <a href="#" class="go-top"> <i class="fa fa-angle-up"></i></a></div>
</footer> -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
