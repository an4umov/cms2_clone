<?php
/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $block common\models\Block */

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

$this->title = 'Добавить контент';
$this->params['breadcrumbs'][] = ['label' => 'Контент', 'url' => ['/'.MenuHelper::FIRST_MENU_CONTENT,],];
$this->params['breadcrumbs'][] = ['label' => $model->getManyTypeTitle($model->type), 'url' => ['index',],];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menuIcon'] = IconHelper::getSpanIcon($model->getTypeIcon($model->type));
?>
<div class="content-create">
    <?= $this->render('_form', [
        'model' => $model,
        'filters' => [],
        'tags' => [],
        'contentFilters' => [],
        'contentFilterPages' => [],
        'contentTags' => [],
        'expanded' => [],
    ]) ?>
</div>