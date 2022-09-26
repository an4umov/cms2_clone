<?php

use common\components\helpers\BlockHelper;
use kartik\sortinput\SortableInput;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $rows \common\models\BlockFieldList[] */
/* @var $model \common\models\BlockField */
?>
<div class="panel panel-info" style="margin-bottom: 0;">
    <div class="panel-heading">
        <div class="row">
            <div class="col-lg-8"><h3 class="panel-title" style="font-size: 15px; font-weight: 600;">Элементы списка</h3></div>
            <div class="col-lg-4">
                <a id="field-list-add-btn" class="btn btn-info btn-xs pull-right" href="#" data-field_id="<?= $model->id ?>"><i class="fa fa-plus"></i></a>
                <?= Html::tag('div', Html::img('/img/loader2.gif', ['style' => 'display: none; width: 22px; vertical-align: middle; margin-right: 5px;',]), ['id' => 'block-field-list-loader', 'class' => 'block-field-list-loader', 'style' => 'display: inline-block; float: right;',]) ?>
            </div>
        </div>
    </div>
    <div class="panel-body task-content" id="block-form-field-list-items">
        <ul id="sortable" class="task-list">
            <? foreach ($rows as $row) { echo BlockHelper::getBlockFieldListItem($row); } ?>
        </ul>
    </div>
</div>
<? $js = 'jQuery( "#sortable" ).sortable();';

    $this->registerJs($js);
