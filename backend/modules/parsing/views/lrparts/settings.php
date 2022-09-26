<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $articlesCount integer */
/* @var $itemsCount integer */
/* @var $itemsMissedCount integer */
/* @var $updated integer */
/* @var $isUpdated boolean */

$this->title = 'Настройка LrParts.ru';
$this->params['breadcrumbs'][] = ['label' => 'Парсинг', 'url' => ['/'.MenuHelper::FIRST_MENU_PARSING,],];
$this->params['breadcrumbs'][] = ['label' => 'LrParts.ru', 'url' => ['/'.MenuHelper::FIRST_MENU_PARSING,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_PARSING;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_PARSING_LRPARTS;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_PARSING);
?>
<div class="content-update">
    <div class="settings-form">
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'method' => 'post',
            'action' => Url::to(['/parsing/lrparts/settings',]),
        ]); ?>

        <?= Html::hiddenInput('is_process', 1); ?>

        <div class="form-group">
            <label class="control-label">Обновление поля <?= \common\models\Articles::tableName() ?>.is_in_epc на
                соответствие артикула в таблице <?= \common\models\ParserLrpartsItems::tableName() ?>.code</label>
        </div>

        <div class="form-group">
            <?= Html::submitButton('<span class="' . \backend\components\helpers\IconHelper::ICON_SAVE . '"></span> Обновить',
                ['class' => 'btn btn-success',]) ?>
        </div>
        <?php ActiveForm::end(); ?>

        <h4>Статистика по таблицам</h4>
        <table id="w0" class="table table-striped table-bordered detail-view">
            <tbody>
            <tr>
                <th><?= \common\models\Articles::tableName() ?></th>
                <td><?= \common\components\helpers\CatalogHelper::formatPrice($articlesCount) ?> строк</td>
            </tr>
            <tr>
                <th><?= \common\models\ParserLrpartsItems::tableName() ?></th>
                <td><?= \common\components\helpers\CatalogHelper::formatPrice($itemsCount) ?> строк</td>
            </tr>
            <tr>
                <th>Нет соответствия между таблицами</th>
                <td><?= \common\components\helpers\CatalogHelper::formatPrice($itemsMissedCount) ?> строк</td>
            </tr>
            <? if ($isUpdated): ?>
            <tr>
                <th>Обновлено</th>
                <td><?= \common\components\helpers\CatalogHelper::formatPrice($updated) ?> строк</td>
            </tr>
            <? endif; ?>
            </tbody>
        </table>
    </div>
</div>