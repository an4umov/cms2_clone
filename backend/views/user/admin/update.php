<?php

use common\models\User;
use yii\bootstrap\Button;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user User */

$this->params['nav-route'] = 'user/admin/index';
?>

<?php

$this->title = Yii::t('lr', 'Update User: {userName}', [
    'userName' => '' . $user->email,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">
        <?php echo $this->render('_form', [
            'user' => $user,
            'profile' => $profile,
        ]) ?>
    </div>
</div>
