<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $source string */
/* @var $parentId mixed */


if (is_null($source)) {
    $source = 'material';
}

if ($source == 'material') {
    $createUrl = ['create'];
} else {
    $createUrl = yii\helpers\Url::to(['/material/create/', 'parentId' => $parentId]);
}

?>


<?php Pjax::begin(); ?>

    <p>
        <?php echo Html::a('Создать материал', $createUrl, ['class' => 'btn btn-success']) ?>
    </p>

<?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'source' => $source, 'parentId' => $parentId]); ?>

<?php Pjax::end(); ?>