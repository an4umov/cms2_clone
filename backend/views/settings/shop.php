<?php

use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $catalogs array */

$this->title = 'Главный уровень магазинов';
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [MenuHelper::SECOND_MENU_SETTINGS_ICON_MAIN_SHOP_LEVEL,],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_ICON_MAIN_SHOP_LEVEL;
?>
<div class="content-update">
    <div class="content-form">
        <?php $form = ActiveForm::begin(); ?>

        <?php foreach ($catalogs as $code => $catalog): ?>
        <div class="form-group">
            <label class="col-sm-2 col-sm-2 control-label" title="<?= $catalog['title'] ?>"><?= $catalog['name'] ?></label>
            <div class="col-sm-10" style="margin-bottom: 20px;">
                <?= \kartik\select2\Select2::widget([
                    'name' => 'type['.$code.']',
                    'value' => $catalog['type'],
                    'data' => \common\models\SettingsMainShopLevel::getTypes(),
                    'options' => [
                        'placeholder' => 'Выберите тип блока',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'tags' => false,
                        'allowClear' => true,
                    ],
                    'hideSearch' => true,
                    'showToggleAll' => false,
                ]); ?>
            </div>
        </div>
        <?php endforeach; ?>

        <div class="form-group">
            <?= Html::submitButton('<span class="'.\backend\components\helpers\IconHelper::ICON_SAVE.'"></span> Сохранить', ['class' => 'btn btn-success',]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>