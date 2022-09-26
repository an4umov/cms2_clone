<?php
/**
 * @var \yii\web\View $this
 * @var string $content
 * @var string $firstCode
 * @var array $breadcrumbs
 * @var array $title
 */

use yii\widgets\Breadcrumbs;
use \frontend\components\widgets\CatalogTreeWidget;

$this->title = $title;
$widgetID = 'catalog-list';
?>
<div class="breadcrumbs" style="display: none;">
    <?
    echo Breadcrumbs::widget([
        'options' => ['class' => false,],
        'itemTemplate' => "<li>{link}</li>\n",
        'encodeLabels' => false,
        'homeLink' => [
            'label' => 'Главная',
            'url' => '/',
        ],
        'links' => $breadcrumbs,
    ]);
    ?>
</div>
<?
echo CatalogTreeWidget::widget(['selectedCode' => $firstCode, 'content' => $content,]);
