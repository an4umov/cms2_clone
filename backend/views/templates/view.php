<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Template */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="box">
    <div class="box-body">
        <p>
            <?php echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Действительно удалить этот шаблон??',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?php echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'content:ntext',
                'active',
                'type',
            ],
        ]) ?>
    </div>
</div>
