<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $user User */

$this->params['nav-route'] = 'user/admin/index';
?>

<h1><?php echo $user->email ?></h1>
<p>
    <?php echo Html::a(Yii::t('user', 'Изменить'), ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
    <?php echo Html::a(Yii::t('user', 'Удалить'), ['delete', 'id' => $user->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('user', 'Удалить?'),
            'method' => 'post',
        ],
    ]) ?>
</p>

<?php echo DetailView::widget([
    'model' => $user,
    'attributes' => [
        'id',
        [
            'attribute' => 'name',
            'value' => $user->profile->full_name,
        ],
        'email',
        [
            'attribute' => 'status',
            'value' => $user->statusText,
        ],
        'created_at',
        'logged_in_at',
    ],
]) ?>
