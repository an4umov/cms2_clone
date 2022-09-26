<?php

use common\models\DepartmentModelList;
use \yii\helpers\Html;

/**
 * @var DepartmentModelList[] $rows
 * @var \common\models\DepartmentModelList $activeDepartmentModelList
 */
?>
<div class="bottom_f">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= $activeDepartmentModelList->name ?>
        </button>
        <? if ($rows): ?>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <? foreach ($rows as $id => $modelList): ?>
                <?= Html::a((!empty($modelList->icon) ? '<i class="'.$modelList->icon.'"></i> ' : '').$modelList->name, '#', ['class' => 'dropdown-item filter-model-btn', 'data' => ['id' => $modelList->id, 'url' => $modelList->url,],]) ?>
            <? endforeach; ?>
        </div>
        <? endif; ?>
    </div>
</div>