<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;

/* @var $this yii\web\View */
/* @var $model common\models\BlockReady */
/* @var $field common\models\BlockField */

$this->title = 'Добавить блок';
$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/blocks']];
$this->params['breadcrumbs'][] = ['label' => 'Готовые блоки', 'url' => ['/'.MenuHelper::FIRST_MENU_BLOCKS.'/'.MenuHelper::SECOND_MENU_BLOCKS_BLOCK_READY,],];
$this->params['breadcrumbs'][] = $this->title;


$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_BLOCK_READY;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_READY);
?>
<div class="block-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
