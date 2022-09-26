<?php

use common\components\helpers\AppHelper;
use \frontend\components\widgets\DepartmentMenuWidget;
use \yii\helpers\Html;

/**
 * @var \common\models\Department[] $departments
 * @var \common\models\Department   $activeDepartment
 * @var array                       $activeCarModel
 * @var array                       $modelList
 * @var string                      $slogan
 * @var int                         $carModelID
 */
?>
<div class="page-header__nav header-nav">
    <div class="header-nav__top">
        <? if (!$modelList): ?><div class="header-nav__text"><?= $slogan ?></div><? endif; ?>
        <? if ($modelList): ?>
        <div class='nav-bar__dropdown' id='nav-bar__dropdown'>
            <div class='nav-bar__dropdown-button' id='nav-bar__dropdown-button'><?= $activeDepartment->name ?></div>
            <ul class='nav-bar__dropdown-selection'>
            <? foreach ($departments as $url => $department): ?>
                <?= Html::tag('li', Html::a($department->name,  $url === DepartmentMenuWidget::ACTIVE_SHOP_ALL ? '/' : '/dep/'.$url, ['class' => 'dropdown-item',])) ?>
            <? endforeach; ?>
            </ul>
        </div>
        <? endif; ?>
    </div>

    <div class="header-nav__low">
        <? if (!$modelList): ?>
        <div class='nav-bar__dropdown' id='nav-bar__dropdown'>
<!--            <div class='nav-bar__dropdown-button' id='nav-bar__dropdown-button'>--><?//= $activeDepartment->name ?><!--</div>-->
            <div class='nav-bar__dropdown-button nav-bar__dropdown-button--active' id='nav-bar__dropdown-button'><?= Html::a($activeDepartment->name,  $activeDepartment->url === '/' ? '/' : '/dep/'.$activeDepartment->url) ?></div>
            <ul class='nav-bar__dropdown-selection'>
            <? foreach ($departments as $url => $department): ?>
                <?= Html::tag('li', Html::a($department->name,  $url === DepartmentMenuWidget::ACTIVE_SHOP_ALL ? '/' : '/dep/'.$url, ['class' => 'dropdown-item',])) ?>
            <? endforeach; ?>
            </ul>
        </div>
        <? endif; ?>

        <? if ($modelList): ?>
        <div class='sub-nav-bar__dropdown' id='sub-nav-bar__dropdown'>
            <div class='sub-nav-bar__dropdown-button' id='sub-nav-bar__dropdown-button'><?= $activeCarModel ? $activeCarModel : 'Выберите модель' ?></div>
            <ul class='sub-nav-bar__dropdown-selection'>
                <?= Html::tag('li', Html::a('Отменить выбор', ['/dep/'.$activeDepartment->url, AppHelper::TEMPLATE_KEY_CAR_MODEL => 0,], ['class' => 'sub-dropdown-item',])) ?>
                <? foreach ($modelList as $id => $name): ?>
                    <?= Html::tag('li', Html::a($name, ['/dep/'.$activeDepartment->url, AppHelper::TEMPLATE_KEY_CAR_MODEL => $id,], ['class' => 'sub-dropdown-item',]), ['class' => ($id === $carModelID ? 'active' : ''),]) ?>
                <? endforeach; ?>
            </ul>
        </div>
        <? endif; ?>
    </div>
</div>
