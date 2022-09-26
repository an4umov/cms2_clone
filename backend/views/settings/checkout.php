<?php

use backend\components\helpers\MenuHelper;
use kartik\checkbox\CheckboxX;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \common\models\Settings */

$this->title = $model->getTypeTitle($model->type);
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index',],];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => [MenuHelper::SECOND_MENU_SETTINGS_NEWS,],];
$this->params['breadcrumbs'][] = 'Изменить';

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_SETTINGS_NEWS;
?>
<div class="content-update">
    <div class="settings-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions(), ['disabled' => true,]) ?>

        <div class="form-group">
            <label class="control-label" for="news-title">Заголовок блока</label>
            <?= Html::textInput('Settings[news_title]', $model->news_title, ['id' => 'news-title', 'class' => 'form-control', 'aria-required' => true, 'placeholder' => 'Заголовок перед блоком',]) ?>
        </div>

        <div class="form-group">
            <label class="control-label" for="news-count">Количество анонсов</label>
            <?= Html::textInput('Settings[news_count]', $model->news_count, ['type' => 'number', 'id' => 'news-count', 'class' => 'form-control', 'aria-required' => true, 'placeholder' => 'количество анонсов, которые будут показаны в свернутом виде',]) ?>
        </div>

        <div class="form-group">
            <label class="control-label" for="news-is-expand">Разворачивать</label>
            <?= CheckboxX::widget([
                'name' => 'Settings[news_is_expand]',
                'value' => !empty($model->news_is_expand),
                'options' => ['id' => 'news-is-expand', 'class' => 'form-control',],
                'pluginOptions' => ['threeState' => false,],
            ]); ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('<span class="' . \backend\components\helpers\IconHelper::ICON_SAVE . '"></span> Сохранить',
                ['class' => 'btn btn-success',]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>