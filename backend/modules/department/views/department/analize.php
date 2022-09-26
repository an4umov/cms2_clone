<?php

use kartik\checkbox\CheckboxX;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $notFoundGroups array */
/* @var $notFoundModels array */
/* @var $broken array */
?>

<div class="tasks-widget">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'form-department-analize',]); ?>
            <div class="task-content">
                <h3 class="display-4 text-danger">Список департаментов, отсутствующих в структуре</h3>
                <? if ($notFoundGroups): ?><div class="alert alert-warning" role="alert">Группы товаров</div><? endif; ?>
                <ul class="task-list">
                    <? foreach ($notFoundGroups as $item): ?>
                    <li class="list-danger">
                        <div class="task-title" style="margin-right: 0;">
                            <span class="task-title-sp"><?= '<strong>'.$item['name'].'</strong> ['.$item['code'].']' ?></span>
                            <div class="pull-right">
                                <?= CheckboxX::widget([
                                    'name' => 'analize['.$item['id'].']',
                                    'value' => false,
                                    'options' => ['id' => 'analize-'.$item['id'], 'class' => 'form-control',],
                                    'pluginOptions' => ['threeState' => false,],
                                ]); ?>
                            </div>
                        </div>
                    </li>
                    <? endforeach; ?>
                </ul>
                <? if ($notFoundModels): ?><div class="alert alert-info" role="alert">Модели</div><? endif; ?>
                <ul class="task-list">
                    <? foreach ($notFoundModels as $item): ?>
                    <li class="list-danger">
                        <div class="task-title" style="margin-right: 0;">
                            <span class="task-title-sp"><?= '<strong>'.$item['name'].'</strong> ['.$item['code'].']' ?></span>
                            <div class="pull-right">
                                <?= CheckboxX::widget([
                                    'name' => 'analize['.$item['id'].']',
                                    'value' => false,
                                    'options' => ['id' => 'analize-'.$item['id'], 'class' => 'form-control',],
                                    'pluginOptions' => ['threeState' => false,],
                                ]); ?>
                            </div>
                        </div>
                    </li>
                    <? endforeach; ?>
                </ul>

                <? if ($broken): ?>
                <h3 class="display-4 text-warning">Список "поломанных" департаментов в структуре</h3>
                <ul class="task-list">
                    <? foreach ($broken as $row): ?>
                    <li class="list-warning">
                        <div class="task-title" style="margin-right: 0;">
                            <span class="task-title-sp"><?= '<strong>'.$row['name'].'</strong> ['.$row['catalog_code'].']' ?></span>
                            <div class="pull-right">
                                <a title="Исправить" target="_blank" href="/department/department/update?id=<?= $row['id'] ?>" role="button" class="btn btn-primary btn-xs"><i class="fas fa-pencil-alt"></i></a>
                            </div>
                        </div>
                    </li>
                    <? endforeach; ?>
                </ul>
                <? endif; ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
