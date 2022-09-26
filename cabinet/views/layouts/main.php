<?php

/* @var $this \yii\web\View */
/* @var $content string */

use cabinet\assets\DashLiteAsset;
use cabinet\assets\AppAsset;
use yii\helpers\Html;
use cabinet\components\helpers\MenuHelper;

DashLiteAsset::register($this);

//AppAsset::register($this);

$isGuest = Yii::$app->user->isGuest;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php echo Html::csrfMetaTags() ?>
    <title><?php echo Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="/images/favicon.png">
    <?php $this->head() ?>
</head>
<body class="nk-body <?= $isGuest ? 'bg-white npc-general pg-auth' : 'bg-lighter npc-default has-sidebar' ?>">
<?php $this->beginBody() ?>
<div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main ">
    <? if (!$isGuest): ?>
    <?
        $displayName = Yii::$app->user->getDisplayName();
        $firstMenu = $this->params['firstMenu'] ?? MenuHelper::FIRST_MENU_HOME_PAGE;
        ?>
        <!-- sidebar @s -->
        <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
            <div class="nk-sidebar-element nk-sidebar-head">
                <div class="nk-sidebar-brand">
                    <a href="/" class="logo-link nk-sidebar-logo" style="color: #526484;">
                        <img class="logo-small logo-img logo-img-small" src="/images/logo_lr.png" alt="logo"> <span class="nk-sidebar-brand-title">Личный кабинет</span>
                    </a>
                </div>
            </div><!-- .nk-sidebar-element -->
            <div class="nk-sidebar-element">
                <div class="nk-sidebar-content">
                    <div class="nk-sidebar-menu" data-simplebar>
                        <ul class="nk-menu">
                            <li class="nk-menu-item">
                                <a href="/settings" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
                                    <span class="nk-menu-text">Профиль</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/delivery" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                                    <span class="nk-menu-text">Адреса доставки</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/transport" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-truck"></em></span>
                                    <span class="nk-menu-text">Транспортные компании</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/contractors" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                                    <span class="nk-menu-text">Контрагенты</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/chat" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-comments"></em></span>
                                    <span class="nk-menu-text">Сообщения</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/bonuses" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-percent"></em></span>
                                    <span class="nk-menu-text">Бонусы</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/balance" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></span>
                                    <span class="nk-menu-text">Баланс</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                            <li class="nk-menu-item">
                                <a href="/files" class="nk-menu-link">
                                    <span class="nk-menu-icon"><em class="icon ni ni-files"></em></span>
                                    <span class="nk-menu-text">Файлы</span>
                                </a>
                            </li><!-- .nk-menu-item -->
                        </ul><!-- .nk-menu -->
                    </div><!-- .nk-sidebar-menu -->
                </div><!-- .nk-sidebar-content -->
            </div><!-- .nk-sidebar-element -->
        </div>
        <!-- sidebar @e -->

        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <div class="nk-header nk-header-fixed is-light">
                <div class="container-fluid">
                    <div class="nk-header-wrap">
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                <li class="dropdown chats-dropdown hide-mb-xs">
                                    <a href="/chat" class="nk-quick-nav-icon">
                                        <div class="icon-status icon-status-na"><em class="icon ni ni-comments"></em></div>
                                    </a>
                                </li>
                                <li class="dropdown notification-dropdown">
                                    <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                                        <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                        <div class="dropdown-head">
                                            <span class="sub-title nk-dropdown-title">Уведомления</span>
                                            <a href="#">Пометить все прочитанным</a>
                                        </div>
                                        <div class="dropdown-body">
                                            <div class="nk-notification">
                                                <div class="nk-notification-item dropdown-inner">
                                                    <div class="nk-notification-icon">
                                                        <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                    </div>
                                                    <div class="nk-notification-content">
                                                        <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                        <div class="nk-notification-time">2 hrs ago</div>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-notification -->
                                        </div><!-- .nk-dropdown-body -->
                                        <div class="dropdown-foot center">
                                            <a href="#">Посмотреть все</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="dropdown user-dropdown">
                                    <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                                        <div class="user-toggle">
                                            <div class="user-avatar sm">
                                                <em class="icon ni ni-user-alt"></em>
                                            </div>
                                            <div class="user-info d-none d-xl-block">
                                                <div class="user-status user-status"><?= Yii::$app->user->getStatusTitle() ?></div>
                                                <div class="user-name dropdown-indicator"><?= $displayName ?></div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                            <div class="user-card">
                                                <div class="user-avatar">
                                                    <span><?= mb_convert_case(mb_substr($displayName, 0, 2), MB_CASE_UPPER) ?></span>
                                                </div>
                                                <div class="user-info">
                                                    <span class="lead-text"><?= $displayName ?></span>
                                                    <span class="sub-text"><?= Yii::$app->user->getEmail() ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li><a href="/settings"><em class="icon ni ni-user-alt"></em><span>Профиль</span></a></li>
                                                <li><a href="/settings/security"><em class="icon ni ni-setting-alt"></em><span>Настройка аккаунта</span></a></li>
                                                <li><a href="/settings/notice"><em class="icon ni ni-setting-alt"></em><span>Подписки и извещения</span></a></li>
                                            </ul>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li>
                                                    <?= Html::a("<em class='icon ni ni-signout'></em> Выход", ['/site/logout'], [
                                                        'data' => ['method' => 'post'],
                                                    ]); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .nk-header-wrap -->
                </div><!-- .container-fliud -->
            </div>
            <!-- main header @e -->
            <!-- content @s -->
            <div class="nk-content ">
                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="components-preview wide-md mx-auto">
                                <div class="nk-block-head nk-block-head-lg wide-sm">
                                    <div class="nk-block-head-content">
                                        <h2 class="nk-block-title fw-normal"><?= $this->title ?></h2>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="nk-block nk-block-lg">
                                    <div class="card">
                                        <div class="card-inner">
                                            <?= \common\widgets\AlertLk::widget(['view' => $this,]) ?>
                                            <?= $content ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
            <!-- footer @s -->
            <div class="nk-footer">
                <div class="container-fluid">
                    <div class="nk-footer-wrap">
                        <div class="nk-footer-copyright"> &copy; <?= date('Y') ?> <a href="http://lr.ru">LR.RU</a>
                        </div>
                        <div class="nk-footer-links">
                            <ul class="nav nav-sm">
                                <li class="nav-item"><a class="nav-link" href="#">Политика</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Информация</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Помощь</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer @e -->
        </div>
        <!-- wrap @s -->
    <? else: ?>
        <!-- wrap @s -->
        <div class="nk-wrap nk-wrap-nosidebar">
            <!-- content @s -->
            <div class="nk-content ">
                <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                    <div class="brand-logo pb-4 text-center">
                        <a href="/" class="logo-link">
                            <img src="/images/logo_lr.png" alt="logo">
                        </a>
                    </div>
                    <div class="card card-bordered">
                        <div class="card-inner card-inner-lg">
                            <?= $content ?>
                        </div>
                    </div>
                </div>
                <div class="nk-footer nk-auth-footer-full">
                    <div class="container wide-lg">
                        <div class="row g-3">
                            <div class="col-lg-6 order-lg-last">
                                <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Политика</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Информация</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Помощь</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <div class="nk-block-content text-center text-lg-left">
                                    <p class="text-soft">&copy; <?= date('Y') ?> <a href="http://lr.ru">LR.RU</a> [Guest]</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- wrap @e -->
        </div>
        <!-- content @e -->
    <? endif; ?>
    </div>
    <!-- main @e -->
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
