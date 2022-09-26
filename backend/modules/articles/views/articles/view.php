<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\old\Articles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="articles-view">

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Действительно хотите удалить статью?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'url_key:ntext',
            'deleted',
            'cache',
            'cache_time:datetime',
            'create_time',
            'last_change',
            'title:ntext',
            'description:ntext',
            'announce:ntext',
            'content:ntext',
            'announce_image:ntext',
            'order_num',
            'show_on_the_main',
            'main_category_id',
            'video_announce:ntext',
            'lr_articles:ntext',
            'pageTitle:ntext',
            'lr_checkResult:ntext',
        ],
    ]) ?>

</div>
