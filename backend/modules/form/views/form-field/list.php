<?php

use kartik\sortinput\SortableInput;

/* @var $this yii\web\View */
/* @var $items array */

if ($items) {
    echo SortableInput::widget([
        'name'=> 'Form[sort_list]',
        'items' => $items,
        'hideInput' => true,
        'options' => ['class' => 'form-control', 'readonly' => true,],
        'sortableOptions' => [
            'itemOptions' => ['style' => 'display: flow-root;',],
        ],
    ]);
} else {
    echo '<p><i class="far fa-frown"></i> Нет данных</p>';
}
