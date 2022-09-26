<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Материалы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php Pjax::begin(); ?>

        <p>
            <?php echo Html::a('Создать материал', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php echo $this->render('_grid', ['dataProvider' => $dataProvider, 'source' => 'material']); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
