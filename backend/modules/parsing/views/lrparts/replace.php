<?php

use backend\components\helpers\IconHelper;
use backend\components\helpers\MenuHelper;
use common\models\Catalog;
use kartik\checkbox\CheckboxX;
use kartik\dialog\Dialog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use \common\components\helpers\DepartmentHelper;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $search string */
/* @var $replace string */
/* @var $rows array */
/* @var $updatedRubrics int */
/* @var $updatedItems int */

$this->title = 'Поиск и замена';
$this->params['breadcrumbs'][] = ['label' => 'Парсинг', 'url' => ['/'.MenuHelper::FIRST_MENU_PARSING,],];
$this->params['breadcrumbs'][] = ['label' => 'LrParts.ru', 'url' => ['/'.MenuHelper::FIRST_MENU_PARSING.'/'.MenuHelper::SECOND_MENU_PARSING_LRPARTS,],];
$this->params['breadcrumbs'][] = $this->title;

$this->params['firstMenu'] = MenuHelper::FIRST_MENU_PARSING;
$this->params['secondMenu'] = MenuHelper::SECOND_MENU_PARSING_LRPARTS;
$this->params['menuIcon'] = \backend\components\helpers\IconHelper::getSpanIcon(IconHelper::ICON_PARSING);
?>
<div class="tasks-widget">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'id' => 'form-lrparts-replace',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'post',
                'options' => ['class' => 'form-inline',],
            ]); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Поиск" name="search" value="<?= $search ?>" style="<?= $search ? 'border-color: #817d7d;' : '' ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Замена" name="replace" value="<?= $replace ?>" style="<?= $replace ? 'border-color: #817d7d;' : '' ?>">
                    </div>
                    <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                    <? if (!empty($replace)): ?>
                    <div class="form-group" style="color: #5aaf60; padding-left: 20px;">
                        <strong>Произведено замен в рубриках: <?= $updatedRubrics ?>, товарах: <?= $updatedItems ?></strong>
                    </div>
                    <? endif; ?>
                </div>
            </div>
            <div class="task-content" style="margin-top: 10px;">
                <? if (!empty($rows['rubrics'])): ?>
                    <div class="alert alert-info" role="alert" style="margin-bottom: 0;font-weight: bold;">Рубрики и подрубрики</div>
                    <ul class="task-list">
                        <? foreach ($rows['rubrics'] as $item): ?>
                            <li class="list-danger">
                                <div class="task-title" style="margin-right: 0;">
                                    <span style="width: 45px; display: inline-block;"><?= $item['id'] ?></span>
                                    <span class="task-title-sp"><?= \common\components\helpers\ParserHelper::highlightWord($item['name'], $search, '#246393') ?></span>
                                    <div class="pull-right">
                                        <?= CheckboxX::widget([
                                            'name' => 'rubrics['.$item['id'].']',
                                            'value' => true,
                                            'options' => ['id' => 'rubric-'.$item['id'], 'class' => 'form-control',],
                                            'pluginOptions' => ['threeState' => false,],
                                        ]); ?>
                                    </div>
                                </div>
                            </li>
                        <? endforeach; ?>
                    </ul>
                <? endif; ?>

                <? if (!empty($rows['items'])): ?>
                    <div class="alert alert-success" role="alert" style="margin-bottom: 0;font-weight: bold;margin-top: 20px;">Товары</div>
                    <ul class="task-list">
                        <? foreach ($rows['items'] as $item): ?>
                            <li class="list-danger">
                                <div class="task-title" style="margin-right: 0;">
                                    <span style="width: 45px; display: inline-block;"><?= $item['id'] ?></span>
                                    <span class="task-title-sp"><?= \common\components\helpers\ParserHelper::highlightWord($item['name'], $search, '#3c763d') ?></span>
                                    <div class="pull-right">
                                        <?= CheckboxX::widget([
                                            'name' => 'items['.$item['id'].']',
                                            'value' => true,
                                            'options' => ['id' => 'item-'.$item['id'], 'class' => 'form-control',],
                                            'pluginOptions' => ['threeState' => false,],
                                        ]); ?>
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

