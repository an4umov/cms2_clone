<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Пункты меню', 'url' => ['index']];
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
                    'confirm' => 'Удалить этот пункт?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?php echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'title',
                'alias',
                'parent_id',
                'status',
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>
</div>
