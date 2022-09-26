<?php
/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $filters array */
/* @var $tags array */
/* @var $expanded array */
/* @var $allContentFilterPages array */
/* @var $contentFilters common\models\ContentFilter[] */
/* @var $contentFilterPages common\models\ContentFilterPage[] */
/* @var $contentTags common\models\ContentCustomTag[] */

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

$this->title = 'Изменить контент ['.$model->getManyTypeTitle($model->type).']: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Контент', 'url' => ['/'.MenuHelper::FIRST_MENU_CONTENT,],];
$this->params['breadcrumbs'][] = ['label' => $model->getManyTypeTitle($model->type), 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id,],];
$this->params['breadcrumbs'][] = 'Изменить';
$this->params['menuIcon'] = IconHelper::getSpanIcon($model->getTypeIcon($model->type));
?>
<div class="content-update">
    <?= $this->render('_form', [
        'model' => $model,
        'filters' => $filters,
        'tags' => $tags,
        'contentFilters' => $contentFilters,
        'contentFilterPages' => $contentFilterPages,
        'allContentFilterPages' => $allContentFilterPages,
        'contentTags' => $contentTags,
        'expanded' => $expanded,
    ]) ?>
</div>
