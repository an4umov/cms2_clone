<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use common\models\Block;

/* @var $this yii\web\View */
/* @var $model common\models\Block */
/* @var $type string */

$this->title = 'Изменить блок: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['/blocks']];
if (!in_array($type, [Block::TYPE_AGGREGATOR,])) {
    $this->params['breadcrumbs'][] = [
        'label' => 'Обычные блоки [' . $model->getTypeTitle($model->type) . ']',
        'url' => ['/' . MenuHelper::FIRST_MENU_BLOCKS . '/' . MenuHelper::SECOND_MENU_BLOCKS_COMMON . '/' . $model->type,],
    ];
}
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_BLOCKS;
if (empty($this->params['secondMenu'])) {
    $this->params['secondMenu'] = MenuHelper::SECOND_MENU_BLOCKS_COMMON;
}
$this->params['thirdMenu'] = $model->type;

$this->params['menuIcon'] = IconHelper::getSpanIcon($model->getTypeIcon($model->type));
?>
<div class="block-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
