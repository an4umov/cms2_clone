<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\components\helpers\ConsoleHelper;

/* @var $this yii\web\View */
/* @var $post array */
/* @var $log array */

$this->title = 'Миграция БД';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [MenuHelper::SECOND_MENU_SETTINGS_MIGRATION,],];

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_MIGRATION;
$this->params['menuIcon'] = IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MIGRATION);

$js = "
var isCheched = false;
jQuery('#migration-select-all').on('click', function () {
    jQuery('.migration-table-item').each(function() {
        if (!isCheched) {
            jQuery( this ).val(1);
        } else {
            jQuery( this ).val(0);
        }
        jQuery( this ).checkboxX('refresh');
    });
    
    isCheched = !isCheched;
});

jQuery('#migration-submit').on('click', function () {
    app.migrate();
});
";
$this->registerJs($js, $this::POS_READY);
?>
<div class="content-update">
    <div class="content-form">
        <div id="migration-result" style="display: none;"></div>

        <?php $form = ActiveForm::begin(['id' => 'migrate-form',]); ?>

        <h3 class="text-primary">Таблицы</h3>
        <?php foreach (ConsoleHelper::MIGRATIONS as $migration): ?>
        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label" for="table-<?= $migration ?>" title="<?= $migration ?>"><?= $migration ?></label>
            <div class="col-sm-10" style="margin-bottom: 20px;">
                <?= CheckboxX::widget([
                    'name' => 'table['.$migration.']',
                    'value' => 0,
                    'options' => ['id' => 'table-'.$migration, 'class' => 'migration-table-item',],
                    'pluginOptions' => [
                        'threeState' => false,
                    ],
                ]); ?>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10" style="margin-bottom: 20px;">
                <?= Html::button('<i class="fas fa-check-double"></i> Выбрать все', ['class' => 'btn btn-default', 'id' => 'migration-select-all',]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::button('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Применить', ['class' => 'btn btn-success', 'id' => 'migration-submit',]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>