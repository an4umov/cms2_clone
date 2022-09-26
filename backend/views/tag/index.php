<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php Pjax::begin(); ?>

        <p>
            <?php echo Html::a('Создать тег', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'label' => 'Название',
                    'attribute' => 'name',
                    /** @var \common\models\Tag $tag */
                    'content' => function ($tag) {
                        return Html::a($tag->name, \yii\helpers\Url::to(['tag/view', 'id' => $tag->id]), [
                            'target' => '_blank'
                        ]);
                    }
                ],
                [
                    'label' => 'Кол-во материалов',
                    /** @var \common\models\Tag $tag */
                    'content' => function ($tag) {
                        return count($tag->materials);
                    }

                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
