<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 * @var amnah\yii2\user\models\Role $role
 * @var yii\widgets\ActiveForm $form
 */

$roles = \Yii::$app->authManager->getRoles();
$module = $this->context->module;
$role = $module->model("Role");

$userRole = \Yii::$app->authManager->getRolesByUser($user->id);

$selectedRoles = [];

foreach ($userRole as $roleName => $role) {
    $selectedRoles[$roleName] = ['selected' => true];
}
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

    <?php echo $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($user, 'newPassword')->passwordInput() ?>

    <?php echo $form->field($profile, 'full_name'); ?>

    <?php echo $form->field($user, 'roles')->dropDownList(\yii\helpers\ArrayHelper::map($roles,
        'name', 'description'), [
        'multiple' => true,
        'options' => $selectedRoles

    ]); ?>


    <?php echo $form->field($user, 'status')->dropDownList(\common\models\User::statuses()); ?>

    <?php $user->banned_at = $user->banned_at ? 1 : 0 ?>
    <?php echo Html::activeLabel($user, 'banned_at', ['label' => Yii::t('user', 'Banned')]); ?>
    <?php echo Html::activeCheckbox($user, 'banned_at'); ?>
    <?php echo Html::error($user, 'banned_at'); ?>

    <?php echo $form->field($user, 'banned_reason'); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('lr', 'Save'), ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
