<?php

use backend\models\UserSearch;
use kartik\select2\Select2;
use yii\bootstrap\Button;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\AuthItem;

/* @var $this yii\web\View */
/* @var $searchModel UserSearch */

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box">
    <div class="box-body">
        <p>
            <?php echo Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
        <?php echo GridView::widget([
            'dataProvider' => $searchModel->search(),
            'layout' => '{items} {pager}',
            'tableOptions' => [
                'class' => 'table table-bordered'
            ],
            'headerRowOptions' => [
                'class' => 'thead-light',
            ],
            'columns' => [
                'id',
                [
                    'attribute' => 'name',
                    'value' => 'profile.full_name',
                ],
                'email',
                [
                    'attribute' => 'item_name',
                    'label' => 'Роль',
                    'value' => 'authAssignment.item_name',
                ],
                [
                    'attribute' => 'status',
                    'value' => 'statusText',
                ],
                'created_at',
                [
                    'class' => \yii\grid\ActionColumn::class,
                    'template' => '{view} {update} {delete} {role}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a(Html::tag('i', '', ['class' => 'fa fa-eye']), $url);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a(Html::tag('i', '', ['class' => 'fa fa-edit']), $url);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a(Html::tag('i', '', ['class' => 'fa fa-trash']), $url, ['data-method' => 'post', 'data-confirm' => 'Удалить?']);
                        },
                        'role' => function ($url, $model, $key) {
                            return Html::a(Html::tag('i', '', ['class' => 'fa fa-user']), [
                                '/auth-item/add-user-role', 'userId' => $model->id
                            ], ['tilte' => 'Роль пользователя']);
                        },
                    ]
                ]
            ]
        ]); ?>
    </div>
</div>

