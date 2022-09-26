<?php

/* @var \yii\web\View $this */
/* @var $searchModel common\models\search\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];

use yii\widgets\ListView;

?>

<div class="container mycontainer">
    <div class="row">
        <div class="col">
            <h1><?= $this->title ?></h1>
        </div>
    </div>
</div>

<?= ListView::widget([
    'id' => 'news-list',
    'dataProvider' => $dataProvider,
    'itemView' => '_index',
    'layout' => "{items}\n <div class=\"container mycontainer\"><div class=\"row\"><div class=\"col-12 ol-sm-12 col-md-12 col-lg-12 col-xl-12\"><div class=\"navigation0\">{pager}</div></div></div></div>",
    'itemOptions' => ['tag' => null,],
    'options' => ['tag' => null,],
    'pager' => [
        'linkOptions' => ['class' => '',],
        'options' => ['class' => '',],
        'activePageCssClass' => 'active',
        'hideOnSinglePage' => false,
        'disabledPageCssClass' => 'disabled',
        'linkContainerOptions' => ['class' => '',],
        'maxButtonCount' => 6,
        'nextPageLabel' => 'следующая <i class="fas fa-angle-double-right"></i>',
        'prevPageLabel' => '<i class="fas fa-angle-double-left"></i> предыдущая',
        'prevPageCssClass' => 'nav_left',
        'nextPageCssClass' => 'nav_right',
    ],
]);
?>