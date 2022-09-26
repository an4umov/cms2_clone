<?php

use common\models\ContentFilter;
use common\models\ContentFilterPage;
use kartik\checkbox\CheckboxX;
use kartik\dialog\Dialog;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use \common\models\Content;
use \common\components\helpers\BlockHelper;


/* @var $this yii\web\View */
/* @var $model common\models\Content */
/* @var $form yii\widgets\ActiveForm */
/* @var $filters array */
/* @var $tags array */
/* @var $expanded array */
/* @var $allContentFilterPages array */
/* @var $contentFilters common\models\ContentFilter[] */
/* @var $contentFilterPages common\models\ContentFilterPage[] */
/* @var $contentTags common\models\ContentCustomTag[] */

if (!$model->isNewRecord) {
    echo Dialog::widget([
        'libName' => 'krajeeDialogContentAdd',
        'options' => [
            'size' => Dialog::SIZE_NORMAL,
            'type' => Dialog::TYPE_INFO,
            'title' => 'Добавление блока',
            'nl2br' => false,
            'buttons' => [
                [
                    'id' => 'cust-cancel-btn',
                    'label' => 'Отмена',
                    'cssClass' => 'btn-outline-secondary',
                    'hotkey' => 'C',
                    'action' => new JsExpression("function(dialog) {
                        return dialog.close();
                    }")
                ],
                [
                    'id' => 'cust-submit-btn',
                    'label' => 'Сохранить',
                    'cssClass' => 'btn-success',
                    'hotkey' => 'S',
                    'action' => new JsExpression("function(dialog) {
                        if (blockAddForm.valid()) {
                            jQuery.when( app.sendAjaxForm('form-content-block-add') ).then(function( response, textStatus, jqXHR ) {
                                if (!!response.ok) {
                                    app.addNotification('Блок добавлен');
                                    app.loadContentBlocks(".$model->id.", '');
                                    //temporary solution
                                    app.refreshPage(0);
                                    return dialog.close();
                                } else {
                                    if (!!response.message) {
                                        app.addNotification(response.message);
                                    }
                                }
                            });
                        }                
                    }")
                ],
            ],
        ],
    ]);

    echo Dialog::widget([
        'libName' => 'krajeeDialogContentDelete',
        'options' => [
            'size' => Dialog::SIZE_NORMAL,
            'type' => Dialog::TYPE_DANGER,
            'title' => 'Удаление блока',
            'nl2br' => false,
        ],
    ]);

    echo Dialog::widget([
        'libName' => 'krajeeDialogContentReady',
        'options' => [
            'size' => Dialog::SIZE_NORMAL,
            'type' => Dialog::TYPE_DEFAULT,
            'title' => 'Приготовление блока',
            'nl2br' => false,
        ],
    ]);
}
?>
<div class="content-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-info">
        <div class="panel-heading"><h3 class="panel-title">Основная информация</h3></div>
        <div class="panel-body">
            <? if (!$model->isNewRecord): ?>
                <?
                $col = 6;
                $indexPage = null;
                if ($model->type === Content::TYPE_PAGE) {
//                    $indexPage = BlockHelper::getIndexPage();
                    $col = 4;
                }
                ?>
                <div class="row">
                    <div class="col-md-<?= $col ?>">
                        <div class="form-group field-content-id">
                            <label class="control-label" for="content-id"><?= $model->getAttributeLabel('id') ?></label>
                            <p><?= $model->id ?></p>
                        </div>
                    </div>
                    <div class="col-md-<?= $col ?>">
                        <div class="form-group field-content-type">
                            <label class="control-label" for="content-type"><?= $model->getAttributeLabel('type') ?></label>
                            <p><?= $model->getTypeTitle($model->type) ?></p>
                        </div>
                    </div>
                    <? if ($model->type === Content::TYPE_PAGE): ?>
                    <div class="col-md-<?= $col ?>">
                        <?= $form->field($model, 'is_index_page')->widget(CheckboxX::class, ['pluginOptions' => ['threeState' => false,], 'disabled' => BlockHelper::isDisableIndexPageCheckbox($model),]) ?>
                    </div>
                    <? endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => 255,]) ?>
                    </div>
                    <div class="col-md-4 field-content-alias-col">
                        <? if ($model->type !== Content::TYPE_PAGE): ?>
                            <?= $form->field($model, 'alias')->textInput(['maxlength' => 255,]) ?>
                            <a href="<?=Yii::$app->params['frontendUrl'] . $model->getContentUrl() ?>" class="external-page-link" target="_blank" title="Посмотреть на сайте"><i class="fas fa-external-link-square-alt"></i></a>
                        <? else: ?>
                            <?= $form->field($model, 'page_index_type')->dropDownList($model->getPageIndexTypeOptions(), ['prompt' => 'Выбрать...',]) ?>
                        <? endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, 'title')->textInput(['maxlength' => 255,]) ?>
                    </div>
                </div>
                <? if (in_array($model->type, [Content::TYPE_NEWS, Content::TYPE_ARTICLE,])): ?>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group field-content-article_numbers">
                                <label class="control-label" for="content-name"><?= $model->getAttributeLabel('article_numbers')?></label>
                                <?= \kartik\select2\Select2::widget([
                                    'name' => 'Content[article_numbers][]',
                                    'value' => $model->getArticleNumbers(),
                                    'data' => [],
                                    'options' => [
                                        'placeholder' => 'Выберите номера артикулов',
                                        'multiple' => true,
                                    ],
                                    'pluginOptions' => [
                                        'tags' => true,
                                        'tokenSeparators' => [',',],
                                        'maximumInputLength' => 15,
                                        'allowClear' => true,
                                    ],
                                    'hideSearch' => true,
                                    'showToggleAll' => false,
                                ]); ?>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group field-content-car_model">
                                <label class="control-label" for="content-name">Модели машин</label>
                                <?= \kartik\select2\Select2::widget([
                                    'name' => 'Content[filters]['.ContentFilter::TYPE_MODEL.'][]',
                                    'value' => $model->getCarModelFilterData(),
                                    'data' => \common\components\helpers\DepartmentHelper::getCarModelOptions(),
                                    'options' => [
                                        'placeholder' => 'Выберите модели машин',
                                        'multiple' => true,
                                    ],
                                    'pluginOptions' => [
                                        'tags' => true,
                                        'tokenSeparators' => [',',],
                                        'maximumInputLength' => 15,
                                        'allowClear' => true,
                                    ],
                                    'hideSearch' => false,
                                    'showToggleAll' => false,
                                ]); ?>
                                <div class="help-block"></div>
                            </div>
                        </div>
                    </div>
                <? endif; ?>
            <? else: ?>
                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions(), ['prompt' => 'Выбрать...',]) ?>
                    </div>
                    <? if ($model->type === Content::TYPE_PAGE): ?>
                    <div class="col-md-2">
                        <?= $form->field($model, 'page_index_type')->dropDownList($model->getPageIndexTypeOptions(), ['prompt' => 'Выбрать...',]) ?>
                    </div>
                    <? endif; ?>
                    <div class="col-md-4">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => 255,]) ?>
                    </div>
                    <? if ($model->type !== Content::TYPE_PAGE): ?>
                    <div class="col-md-4">
                        <?= $form->field($model, 'alias')->textInput(['maxlength' => 255,]) ?>
                    </div>
                    <? endif; ?>
                </div>
            <? endif; ?>
        </div>
    </div>

    <? if ($model->type === Content::TYPE_NEWS || $model->type === Content::TYPE_ARTICLE): ?>
    <div class="row">
    <div class="col-lg-6 col-xl-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Привязка контента к структуре
                <span class="tools pull-right">
                <a class="fa fa-chevron-up" href="javascript:;"></a>
            </span>
            </h3>
        </div>
        <div class="panel-body tasks-widget content-form-filter-list" style="display: none;">
            <? if ($model->isNewRecord): ?>
                <span class="fa fa-info-circle text-primary"></span> Сохраните контент для привязки к структуре
            <? else: ?>
                <div class="task-content">
                    <ul class="task-list ui-sortable">
                    <? foreach ($filters[ContentFilter::TYPE_DEPARTMENT] as $departmentID => $departmentData): ?>
                        <li class="list-danger">
                            <div class="task-title" style="margin-right: 0;">
                                <span class="task-title-sp"><?= '<strong>'.$departmentData['name'].'</strong> [Департамент]' ?></span>
                                <div class="pull-right">
                                    <?= CheckboxX::widget([
                                        'name' => 'Content[filters]['.ContentFilter::TYPE_DEPARTMENT.']['.$departmentData['id'].']',
                                        'value' => BlockHelper::isContentFilterChecked($contentFilters, $departmentData),
                                        'options' => ['id' => 'filter-'.ContentFilter::TYPE_DEPARTMENT.'-'.$departmentData['id'], 'class' => 'form-control',],
                                        'pluginOptions' => ['threeState' => false,],
//                                        'disabled' => BlockHelper::isContentFilterPageDisabled($model->id, $allContentFilterPages, ContentFilterPage::TYPE_DEPARTMENT, $departmentID),
                                    ]); ?>
                                </div>
                            </div>
                        </li>
                        <? if (!empty($filters[ContentFilter::TYPE_MENU])): ?>
                            <? foreach ($filters[ContentFilter::TYPE_MENU] as $departmentMenuID => $departmentMenuData): ?>
                                <? if ($departmentMenuData['department_id'] == $departmentID): ?>
                                    <li class="list-info">
                                        <div class="task-title" style="margin-right: 0;margin-left: 40px;">
                                            <span class="task-title-sp">
                                                <?= '<strong>'.$departmentData['name'].'</strong> <i class="fa fa-arrow-right"></i> '.$departmentMenuData['name'].' [Меню]' ?>
                                            </span>
                                            <div class="pull-right">
                                                <?= CheckboxX::widget([
                                                    'name' => 'Content[filters]['.ContentFilter::TYPE_MENU.']['.$departmentMenuID.']',
                                                    'value' => BlockHelper::isContentFilterChecked($contentFilters, $departmentMenuData),
                                                    'options' => ['id' => 'filter-'.ContentFilter::TYPE_MENU.'-'.$departmentMenuID, 'class' => 'form-control',],
                                                    'pluginOptions' => ['threeState' => false,],
    //                                                'disabled' => BlockHelper::isContentFilterPageDisabled($model->id, $allContentFilterPages, ContentFilterPage::TYPE_DEPARTMENT_MENU, $departmentMenuID),
                                                ]); ?>
                                            </div>
                                        </div>
                                    </li>

                                    <? if (!empty($filters[ContentFilter::TYPE_TAG])): ?>
                                        <? foreach ($filters[ContentFilter::TYPE_TAG] as $departmentMenuTagID => $departmentMenuTagData): ?>
                                            <? if ($departmentMenuTagData['department_menu_id'] == $departmentMenuID): ?>
                                                <li class="list-warning">
                                                    <div class="task-title" style="margin-right: 0;margin-left: 80px;">
                                                        <span class="task-title-sp">
                                                            <?= '<strong>'.$departmentData['name'].'</strong> <i class="fa fa-arrow-right"></i> '.$departmentMenuData['name'].' <i class="fa fa-arrow-right"></i> '.$departmentMenuTagData['name'].' [Тематика]' ?>
                                                        </span>
                                                        <div class="pull-right">
                                                            <?= CheckboxX::widget([
                                                                'name' => 'Content[filters]['.ContentFilter::TYPE_TAG.']['.$departmentMenuTagID.']',
                                                                'value' => BlockHelper::isContentFilterChecked($contentFilters, $departmentMenuTagData),
                                                                'options' => ['id' => 'filter-'.ContentFilter::TYPE_TAG.'-'.$departmentMenuTagID, 'class' => 'form-control',],
                                                                'pluginOptions' => ['threeState' => false,],
                                                            ]); ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            <? endif; ?>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                <? endif; ?>
                            <? endforeach; ?>
                        <? endif; ?>
                    <? endforeach; ?>
                    </ul>
                </div>
            <? endif; ?>
        </div>
    </div>

    <? if (false): //отменена фильтрация для страниц ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Привязка к фильтрам
                <span class="tools pull-right">
                <a class="fa fa-chevron-up" href="javascript:;"></a>
            </span>
            </h3>
        </div>
        <div class="panel-body tasks-widget content-form-filter-list" style="display: none;">
            <? if ($model->isNewRecord): ?>
                <span class="fa fa-info-circle text-primary"></span> Сохраните контент для привязки к фильтрам
            <? else: ?>
                <div class="task-content">
                    <ul class="task-list ui-sortable">
                        <li class="list-danger">
                            <div class="task-title" style="margin-right: 0;">
                                <span class="task-title-sp"><strong class="text-danger">ДЕПАРТАМЕНТЫ</strong></span>
                            </div>
                        </li>
                        <? foreach ($filters[ContentFilter::TYPE_DEPARTMENT] as $filter): ?>
                            <li class="list-danger">
                                <div class="task-title" style="margin-right: 0;">
                                <span class="task-title-sp">
                                    <?= $filter['name'] ?>
                                </span>
                                    <div class="pull-right">
                                        <?= CheckboxX::widget([
                                            'name' => 'Content[filters]['.ContentFilter::TYPE_DEPARTMENT.']['.$filter['id'].']',
                                            'value' => BlockHelper::isContentFilterChecked($contentFilters, $filter),
                                            'options' => ['id' => 'filter-'.ContentFilter::TYPE_DEPARTMENT.'-'.$filter['id'], 'class' => 'form-control',],
                                            'pluginOptions' => ['threeState' => false,],
                                        ]); ?>
                                    </div>
                                </div>
                            </li>
                        <? endforeach; ?>

                        <li class="list-info">
                            <div class="task-title" style="margin-right: 0;">
                                <span class="task-title-sp"><strong class="text-primary">МЕНЮ</strong></span>
                            </div>
                        </li>
                        <? foreach ($filters[ContentFilter::TYPE_MENU] as $filter): ?>
                        <li class="list-info">
                            <div class="task-title" style="margin-right: 0;">
                                <span class="task-title-sp">
                                    <?= '<strong>'.$filter['department_name'].'</strong> <i class="fa fa-arrow-right"></i> '.$filter['name'] ?>
                                </span>
                                <div class="pull-right">
                                    <?= CheckboxX::widget([
                                        'name' => 'Content[filters]['.ContentFilter::TYPE_MENU.']['.$filter['id'].']',
                                        'value' => BlockHelper::isContentFilterChecked($contentFilters, $filter),
                                        'options' => ['id' => 'filter-'.ContentFilter::TYPE_MENU.'-'.$filter['id'], 'class' => 'form-control',],
                                        'pluginOptions' => ['threeState' => false,],
                                    ]); ?>
                                </div>
                            </div>
                        </li>
                        <? endforeach; ?>

                        <li class="list-warning">
                            <div class="task-title" style="margin-right: 0;">
                                <span class="task-title-sp"><strong class="text-warning">ТЕМАТИКИ</strong></span>
                            </div>
                        </li>
                        <? foreach ($filters[ContentFilter::TYPE_TAG] as $filter): ?>
                        <li class="list-warning">
                            <div class="task-title" style="margin-right: 0;">
                                <span class="task-title-sp">
                                    <?= '<strong>'.$filter['department_name'].'</strong> <i class="fa fa-arrow-right"></i> '.$filter['department_menu_name'].' <i class="fa fa-arrow-right"></i> '.$filter['name'] ?>
                                </span>
                                <div class="pull-right">
                                    <?= CheckboxX::widget([
                                        'name' => 'Content[filters]['.ContentFilter::TYPE_TAG.']['.$filter['id'].']',
                                        'value' => BlockHelper::isContentFilterChecked($contentFilters, $filter),
                                        'options' => ['id' => 'filter-'.ContentFilter::TYPE_TAG.'-'.$filter['id'], 'class' => 'form-control',],
                                        'pluginOptions' => ['threeState' => false,],
                                    ]); ?>
                                </div>
                            </div>
                        </li>
                        <? endforeach; ?>
                    </ul>
                </div>
            <? endif; ?>
        </div>
    </div>
    <? endif; ?>
    </div>

    <div class="col-lg-6 col-xl-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Привязка к тегам
                    <span class="tools pull-right">
                        <a class="fa fa-chevron-up" href="javascript:;"></a>
                    </span>
                </h3>
            </div>
            <div class="panel-body tasks-widget content-form-filter-list" style="display: none;">
                <? if ($model->isNewRecord): ?>
                    <span class="fa fa-info-circle text-primary"></span> Сохраните контент для привязки тегов
                <? else: ?>
                    <div class="task-content">
                        <ul class="task-list ui-sortable">
                            <? foreach ($tags as $tag): ?>
                            <li class="list-success">
                                <div class="task-title" style="margin-right: 0;">
                                    <span class="task-title-sp">
                                        <?= '<i class="'.\backend\components\helpers\IconHelper::ICON_TAG.'"></i> '.$tag['name'] ?>
                                    </span>
                                    <div class="pull-right">
                                        <?= CheckboxX::widget([
                                            'name' => 'Content[tags]['.$tag['id'].']',
                                            'value' => BlockHelper::isContentTagChecked($contentTags, $tag),
                                            'options' => ['id' => 'tag-'.$tag['id'], 'class' => 'form-control',],
                                            'pluginOptions' => ['threeState' => false,],
                                        ]); ?>
                                    </div>
                                </div>
                            </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                <? endif; ?>
            </div>
        </div>
    </div>
    </div>
    <? endif; ?>


    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-11"><h3 class="panel-title">Блоки</h3></div>
                <div class="col-lg-1">
                    <? if (!$model->isNewRecord): ?>
                        <a id="content-add-btn" class="btn btn-info btn-xs pull-right" href="#" data-content_id="<?= $model->id ?>"><i class="fa fa-plus"></i></a>
                        <?= Html::tag('div', Html::img('/img/loader2.gif', ['style' => 'display: none; width: 22px; vertical-align: middle; margin-right: 5px;',]), ['id' => 'content-loader', 'class' => 'content-loader', 'style' => 'display: inline-block; float: right;',]) ?>
                    <? endif; ?>
                </div>
            </div>
        </div>
        <div class="panel-body" id="content-form-block-list"><? if ($model->isNewRecord): ?><span class="fa fa-info-circle text-primary"></span> Сохраните контент для добавления блоков<? else: ?><img src="/img/loader2.gif" alt="" style="width: 22px; vertical-align: text-top; margin-right: 5px;"> Загрузка данных...<? endif; ?></div>
    </div>

    <div class="form-group sticky-bottom bottom-submit-buttons">
        <?= \common\components\helpers\AppHelper::getSubmitButtons() ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<? if (!$model->isNewRecord) {
    $js = 'app.loadContentBlocks(' . $model->id . ', "'.implode(',', $expanded).'");';
    $js2 = '
    jQuery("body").on("click", ".panel .tools .fa-chevron-up", function () {
        let btn = jQuery(this);
        let contentBlockID = btn.data("id");
        let blockType = btn.data("type");
        var el = btn.closest(".panel").children(".panel-body");

        btn.removeClass("fa-chevron-up").addClass("fa-chevron-down");
        el.slideDown(200);
        jQuery("#block-field-expanded-"+blockType+"-"+contentBlockID).val(1);
    });    
    jQuery("body").on("click", ".panel .tools .fa-chevron-down", function () {
        let btn = jQuery(this);
        let contentBlockID = btn.data("id");
        let blockType = btn.data("type");
        var el = btn.closest(".panel").children(".panel-body");
        
        btn.removeClass("fa-chevron-down").addClass("fa-chevron-up");
        el.slideUp(200);
        jQuery("#block-field-expanded-"+blockType+"-"+contentBlockID).val(0);
    });    
    ';

    $this->registerJs($js);
    $this->registerJs($js2);
    $this->registerCss('.sp-preview {margin-right: 0 !important;}');
}