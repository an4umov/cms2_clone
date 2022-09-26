<?php

use backend\components\helpers\MenuHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\ContentTree;

/* @var $this yii\web\View */
/* @var $model common\models\ParserLrpartsRubrics */
/* @var $parentModel common\models\ParserLrpartsRubrics */

$treeID = 'content-tree';

?>
<section class="panel">
    <div class="panel-body">
        <div class="col-md-12">
            <h4>Виртуальная папка "<?= $model->name ?>"</h4>
            <?php $form = ActiveForm::begin([
                'id' => 'form-lrparts-rubrics',
                'enableAjaxValidation' => false,
                'enableClientValidation' => false,
                'method' => 'post',
                'action' => Url::to(['/'.MenuHelper::FIRST_MENU_CONTENT.'/'.MenuHelper::SECOND_MENU_CONTENT_TREE.'/folder?id='.$model->id,]),
                'options' => ['class' => 'form-horizontal', 'name' => 'form_lrparts_rubrics',],
            ]); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('name')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'name', ['maxlength' => 255, 'class' => 'form-control',]);  ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('description')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextarea($model, 'description', ['rows' => 5, 'class' => 'form-control',]);  ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label"><?= $model->getAttributeLabel('sort')?></label>
                <div class="col-sm-9">
                    <?= Html::activeTextInput($model, 'sort', ['maxlength' => 5, 'class' => 'form-control', 'style' => ['width' => '25%',]]);  ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <?php echo Html::button('Сохранить', ['class' => 'btn btn-success', 'id' => 'form-lrparts-rubrics-save-btn',]) ?>
                    <?php echo Html::button('Удалить', ['class' => 'btn btn-danger pull-right', 'id' => 'form-lrparts-rubrics-remove-btn']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</section>

<script>
jQuery(function () {
    jQuery('#form-lrparts-rubrics-save-btn').on('click', function () {
        jQuery.when(app.sendAjaxFileForm('form_lrparts_rubrics') ).then(function( response, textStatus, jqXHR ) {
            if (!!response.ok) {
                app.addNotification('Папка обновлена');
            } else {
                if (!!response.message) {
                    app.addError(response.message);
                }
            }
        });

        return false;
    });
    app.contentTreeID = "<?=$treeID?>";
    app.contentTreeTypeFolder = "<?=ContentTree::TREE_TYPE_FOLDER?>";
    var zTree = jQuery.fn.zTree.getZTreeObj(app.contentTreeID);
    var nodes = zTree.getNodesByParam("type", app.contentTreeTypeFolder, null);
    
    for(const node of nodes) {
        if (node.id === <?=$model->id?>) {
            var treeNode = node;
        }
    }
    jQuery('#form-lrparts-rubrics-remove-btn').on('click', function () {
        var check = app.beforeRemoveContentTree('content-tree', treeNode);
        if (check == true) {
            app.onRemoveContentTree(false, 'content-tree', treeNode);
        }
        return false;
    });

    var removeBtnVisibality = app.showRemoveBtnContentTree('content-tree', treeNode);
    if (removeBtnVisibality == false) {
        $('#form-lrparts-rubrics-remove-btn').hide();
    }
});
</script>