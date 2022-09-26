<?php

use common\models\Material;
use common\models\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'parent_id')->dropDownList(
            ArrayHelper::map(Menu::find()->all(), 'id', 'title'),
            [
                $model->parent_id => ['selected' => true]
            ]
    ) ?>

    <?php echo $form->field($model, 'status')->checkbox([
        'checked' => $model->status === Material::STATUS_PUBLISHED
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-green"><i class="fa fa-plus"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Создан</span>
                    <span class="info-box-number">
                        <?php echo Yii::$app->formatter->asDateTime($model->created_at, 'php:d.m.Y H:i')?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-blue"><i class="fa fa-edit"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Обновлен</span>
                    <span class="info-box-number">
                        <?php echo Yii::$app->formatter->asDateTime($model->updated_at, 'php:d.m.Y H:i')?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
