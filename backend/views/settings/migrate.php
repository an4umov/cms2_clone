<?php

/* @var $this yii\web\View */
/* @var $log array */


?>
<h3 class="text-info">Результат миграции</h3>
<div class="panel-group m-bot20" id="accordion" style="margin-bottom: 40px;">
    <? foreach ($log as $table => $items): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $table ?>">
                        Таблица <strong><?= $table ?></strong> <span class="badge bg-success"><?= count($items) ?></span>
                    </a>
                </h4>
            </div>
            <div id="collapse-<?= $table ?>" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="list-group">
                        <? foreach ($items as $item): ?>
                            <li class="list-group-item"><?= $item ?></li>
                        <? endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <? endforeach; ?>
</div>