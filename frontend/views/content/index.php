<?php
use frontend\models\search\ContentSearch;

/* @var string $type */
/* @var \yii\web\View $this */

$searchModel = new ContentSearch();
$this->title = $searchModel->getManyTypeTitle($type);
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
?>

<?php echo \frontend\components\widgets\BreadcrumbsWidget::widget(['breadcrumbs' => $breadcrumbs,]); ?>
<article class="news-post">
    <h1>
        <?= $this->title ?>
    </h1>
</article>
<?= \frontend\components\widgets\ShopContentWidget::widget(['filter' => ['type' => $type,],]) ?>