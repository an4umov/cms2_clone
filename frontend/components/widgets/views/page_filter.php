<?php
use \yii\helpers\Html;
use yii\widgets\ActiveForm;
use nirvana\showloading\ShowLoadingAsset;

/**
 * @var \common\models\DepartmentMenu    $activeDepartmentMenu
 * @var \common\models\Department        $department
 * @var array                            $filter
 * @var array                            $tagList
 * @var string                           $pjaxId
 * @var \common\models\DepartmentModel[] $departmentModels
 */

$searchFormClass = $pjaxId.'-form';

$format = <<< SCRIPT
function formatFilterOptions(state) {
    return state.text;   
}
SCRIPT;

$pjaxOnChange = <<< SCRIPT
jQuery(document).on('submit', '.{$searchFormClass}', function(event){
     event.preventDefault();

    jQuery.pjax.submit(event, '#{$pjaxId}');
});
jQuery(function () {
    jQuery('.{$searchFormClass}').on('click', 'a.filter-tag-btn', function(e){
        e.preventDefault();
        jQuery('#{$pjaxId}-tag').val(jQuery(this).data('id'));
        jQuery('.{$searchFormClass}').submit();
    });
    jQuery('.{$searchFormClass}').on('click', 'a.filter-model-btn', function(e){
        e.preventDefault();
        jQuery('#{$pjaxId}-model').val(jQuery(this).data('id'));
        jQuery('.{$searchFormClass}').submit();
    });
});
SCRIPT;

$onChange = <<< SCRIPT
jQuery(function () {
    jQuery('.{$searchFormClass}').on('click', 'a.filter-tag-btn', function(e){
        e.preventDefault();
        
        var url = new URL(window.location.href);
        var theme = jQuery(this).data('url');
        var model = url.searchParams.get("model");
        var query = app.encodeQueryData(app.prepareQueryData(theme, model));
        
        window.location.href = window.location.origin + window.location.pathname + "?" + query;
    });
    jQuery('.{$searchFormClass}').on('click', 'a.filter-model-btn', function(e){
        e.preventDefault();
        
        var url = new URL(window.location.href);
        var theme = url.searchParams.get("theme");
        var model = jQuery(this).data('url');
        var query = app.encodeQueryData(app.prepareQueryData(theme, model));
        
        window.location.href = window.location.origin + window.location.pathname + "?" + query;
    });
});
SCRIPT;

$pjaxLoader = <<< SCRIPT
jQuery(document).on('pjax:send', function() {
  jQuery('#{$pjaxId}').showLoading();
});
jQuery(document).on('pjax:complete', function() {
  jQuery('#{$pjaxId}').hideLoading();
});
SCRIPT;

//$this->registerJs($format, $this::POS_HEAD);
//$this->registerJs($onChange, $this::POS_END);
//$this->registerJs($pjaxOnChange, $this::POS_END);
//$this->registerJs($pjaxLoader, $this::POS_END);

//ShowLoadingAsset::register($this);

$form = ActiveForm::begin([
    'method' => 'post',
    'options' => ['data' => ['pjax' => true,], 'class' => $searchFormClass,],
]);

echo Html::hiddenInput('department_id', $department ? $department->id : 0, ['id' => $pjaxId.'-department',]);
echo Html::hiddenInput('menu_id', $activeDepartmentMenu ? $activeDepartmentMenu->id : 0, ['id' => $pjaxId.'-menu',]);
echo Html::hiddenInput('tag_id', $filter['tag_id'], ['id' => $pjaxId.'-tag',]);
echo Html::hiddenInput('model_id', $filter['model_id'], ['id' => $pjaxId.'-model',]);

//print_r($filter);
//print_r($tagList);

if ($departmentModels): ?>
    <? foreach ($departmentModels as $model): ?>
    <div class="container mycontainer">
        <div class="filter_<?= rand(1, 2) ?>">
            <div class="row ">
                <div class="col-12 ol-sm-12 col-md-12 col-lg-9 col-xl-9">
                    <ul>
                    <?
                    foreach ($tagList as $tagListItem) {
                        echo Html::tag(
                            'li',
                            Html::a((!empty($tagListItem['icon']) ? '<i class="' . $tagListItem['icon'] . '"></i> ' : '') . $tagListItem['name'],
                                '#', [
                                    'class' => 'filter-tag-btn',
                                    'data' => ['id' => $tagListItem['id'], 'url' => $tagListItem['url'],],
                                ]),
                            ['class' => ($filter['tag_id'] === (int)$tagListItem['id'] ? 'active' : ''),]
                        );
                    }
                    ?>
                    </ul>
                </div>
                <div class="col-12 ol-sm-12 col-md-12 col-lg-3 col-xl-3">
                    <div class="ban_f">
                        <div class="top_f">
                            <div class="icon_f"><img src="/img/lr_f.svg" alt=""></div>
                            <div class="title_f"><span><?= $model->word_1 ?></span> <?= $model->word_2 ?></div>
                        </div>
                        <?= \frontend\components\widgets\DepartmentModelMenuWidget::widget(['model' => $model, 'active_model_id' => $filter['model_id'], 'active_tag_id' => $filter['tag_id'],]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? endforeach; ?>
<? endif; ?>
<?php ActiveForm::end();