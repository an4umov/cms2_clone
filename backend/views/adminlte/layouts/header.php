<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?php echo Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"></li>
                        <li>
                            <ul class="menu"></ul>
                        </li>
                        <li class="footer"><a href="#">Посмотреть все сообщения</a></li>
                    </ul>
                </li>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"></li>
                        <li>
                            <ul class="menu"></ul>
                        </li>
                        <li class="footer"><a href="#">Показать все</a></li>
                    </ul>
                </li>

                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-flag-o"></i>
                        <span class="label label-danger"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header"></li>
                        <li>
                            <ul class="menu"></ul>
                        </li>
                        <li class="footer">
                            <a href="#">Показать все задачи</a>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name=<?php echo \Yii::$app->user->identity->username ?>" class="user-image" alt="<?php echo \Yii::$app->user->identity->username ?>"/>
                        <span class="hidden-xs"><?php echo \Yii::$app->user->identity->username ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="https://ui-avatars.com/api/?name=<?php echo \Yii::$app->user->identity->username ?>" class="img-circle"
                                 alt="<?php echo \Yii::$app->user->identity->username ?>"/>

                            <p>
                                <?php echo \Yii::$app->user->identity->username ?>
                                <small><?php echo \Yii::$app->formatter->asDate(\Yii::$app->user->identity->created_at, 'd.m.Y') ?></small>
                            </p>
                        </li>
                        <!-- Menu Body
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <!--<div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>-->
                            <div>
                                <?php echo Html::a(
                                    'Выход',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
