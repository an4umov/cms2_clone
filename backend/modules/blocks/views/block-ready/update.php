<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Block */

$this->title = 'Изменить блок: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/blocks']];
$this->params['breadcrumbs'][] = ['label' => 'Готовые блоки', 'url' => ['/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_BLOCK_READY,],];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_BLOCK_READY;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_READY);
?>
<div class="block-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
