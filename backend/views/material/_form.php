<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Material */
/* @var $form yii\widgets\ActiveForm */
/* @var $templatesList array*/

$tags = \common\models\Tag::find()->all();

$templatesList = (new \services\WidgetsService())->templatesList();

$this->registerJsVar('templatesList', $templatesList, yii\web\View::POS_HEAD);

$CSS = <<<CSS
.redactor-visual {
    margin-bottom: 1px;
    padding: 10px;
    border: 20px solid #bfe2f2;
    background-color: #eb6dff;
}
CSS;

$this->registerCss($CSS);


?>

<div class="material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php
    $aliasField = $form->field($model, 'alias');
    $aliasField->enableClientValidation = false;
    echo $aliasField->textInput(['maxlength' => true]);
    ?>
    <?php echo $form->field($model, 'type_id')->dropDownList(\common\models\Material::getTypes(), [
        $model->type_id => ['selected' => true]
    ]) ?>

    <?php echo $form->field($model, 'status')->checkbox([
        'checked' => $model->status === \common\models\Material::STATUS_PUBLISHED
    ]) ?>
    <?php echo $form->field($model, 'is_main')->checkbox() ?>


    <?php echo $form->field($model, 'materialPreview')->fileInput() ?>

    <div class="row">
        <div class="col-sm-4">
            <div class="form-group highlight-addon field-menu-id">
                <label for="">Создан</label>
                <input class="form-control" type="text" disabled="disabled" value="<?php echo !is_null($model->created_at) ? Yii::$app->formatter->asDateTime($model->created_at, 'php:d.m.Y H:i') : '' ?>">

                <div class="help-block"></div>

            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group highlight-addon field-menu-id">
                <label for="">Обновлен</label>
                <input class="form-control" type="text" disabled="disabled" value="<?php echo !is_null($model->updated_at) ? Yii::$app->formatter->asDateTime($model->updated_at, 'php:d.m.Y H:i') : '' ?>">

                <div class="help-block"></div>

            </div>
        </div>
    </div>

    <?php echo $form->field($model, 'materialTags')->widget(\kartik\select2\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map($tags, 'name', 'name'),
        'options' => [
            'placeholder' => 'Выберите теги',
            'multiple' => true
        ],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ]);?>

    <?php echo $form->field($model, 'content')->widget(zxbodya\yii2\tinymce\TinyMce::class, [
            'settings' => [
                    'height' => 300,
                'plugins' => [
                        "json_visualizer advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "template paste textcolor"
                ],
                'content_css' => '/css/tinymce.css',
                //"menubar" => "view",
                'templates' => $templatesList,
                "toolbar" => "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor| visual_blocks",
                "selector" => "textarea#editable"
            ]
    ]); ?>

    <p>
        <small>Комментарии: /* текст комментария */</small>
    </p>

    <?php /*echo $form->field($model, 'content', [
        'inputOptions' => [
            'value' => Yii::$app->formatter->asHtml($model->content),
        ]
    ])->widget(vova07\imperavi\Widget::class, [
        'name' => 'redactor',
        'settings' => [
            'paragraphize' => false,
            'replaceDivs' => false,
            'lang' => 'ru',
            'minHeight' => 200,
            'imageManagerJson' => \yii\helpers\Url::to(['/material/images-list']),
            'imageUpload' => \yii\helpers\Url::to(['/material/image-upload/']),
            'imageFigure' => true,
            'plugins' => [
                'fullscreen', 'fontsize', 'fontfamily', 'table', 'fontcolor', 'counter', 'definedlinks', 'limiter', 'imagemanager',
                'codes', 'visualblocks'
            ],

            'templates' => $templatesList,
        ],
    ])*/ ?>


    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', [
            'class' => 'btn btn-success material_save',
            'data-main' => $model->is_main
        ]) ?>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton('Сохранить и продолжить', [
                'name' => 'continue',
            'class' => 'btn btn-success material_save',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php



//$this->registerJsFile(\yii\helpers\Url::to('js/plugins/codes/codes.js'), [
//        'depends' => \backend\assets\AppAsset::class
//]);

$this->registerJsFile(\yii\helpers\Url::to('js/plugins/codes/tinymce_json_visualizer.js'), [
    'depends' => \backend\assets\AppAsset::class
]);

?>

<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<script type="text/template" id="modal_tmpl">
    <div class="links-list-item">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Урл</label>
            <div class="col-sm-10">
                <input class="href form-control" type="text">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Текст</label>
            <div class="col-sm-10">
                <input class="text form-control" type="text" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-small delete" data-service-id="0">Удалить</button>
            </div>
        </div>
    </div>
    <br>
</script>





