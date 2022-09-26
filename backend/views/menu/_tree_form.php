<?php

use backend\assets\AppAsset;
use common\models\Menu;
use common\models\Tag;
use kartik\select2\Select2;
use services\UrlService;
use services\WidgetsService;
use yii\base\View;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var Menu $node
 */

$urlService = new UrlService();

$templatesList = ( new WidgetsService() )->templatesList();
$tags = Tag::find()->all();

$form = ActiveForm::begin();
echo $form->field($node, 'front_visible')->checkbox();
/*echo $form->field($node, 'h1')->textInput();
echo $form->field($node, 'meta_keywords')->textInput();
echo $form->field($node, 'meta_description')->textInput();*/
echo $form->field($node, 'alias')->textInput();

//echo $form->field($node, 'menuTags')->widget(Select2::class, [
//    'data' => ArrayHelper::map($tags, 'name', 'name'),
//    'options' => [
//        'placeholder' => 'Выберите теги',
//        'multiple' => true
//    ],
//    'pluginOptions' => [
//        'tags' => true,
//        'tokenSeparators' => [',', ' '],
//        'maximumInputLength' => 10
//    ],
//]);


ActiveForm::end();


//if ( ! $node->isNewRecord ) {
//
//
//    $dataProvider = new ActiveDataProvider([
//        'query' => $node->getMaterials(),
//        'pagination' => [
//            'pageSize' => 20,
//        ],
//    ]);
//
//    echo $this->render('../material/_grid_pjax', [
//        'dataProvider' => $dataProvider,
//        'source' => Menu::SOURCE,
//        'parentId' => $node->id
//    ]);
//}

?>
<?php $this->registerJsFile(Url::to('js/plugins/codes/codes.js'), [
    'depends' => AppAsset::class
]); ?>
