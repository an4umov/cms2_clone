<?php

use backend\components\helpers\MenuHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;
$this->params['firstMenu'] = MenuHelper::FIRST_MENU_SETTINGS;
?>
<div class="row">
    <div class="col-lg-6">
        <section class="panel post-wrap pro-box">
            <aside style="border: 1px solid #f1f2f7;">
                <div class="post-info">
                    <span class="arrow-pro right"></span>
                    <div class="panel-body">
                        <h1><strong>Header</strong> <br> Настройка сайта</h1>
                        <div class="desk yellow">
                            <p></p>
                            <p>Перед началом работы необходимо создать <a href="/blocks/setting/update?id=7" style="text-decoration: underline;">блок</a> в разделе <a href="/blocks/setting" style="text-decoration: underline;">Настройка</a> и добавить в него необходимые поля</p>
                        </div>
                    </div>
                </div>
            </aside>
            <aside class="post-highlight yellow v-align">
                <div class="panel-body text-center">
                    <div class="pro-thumb_">
                        <a href="/settings/header"><i class="far fa-hand-point-up" style="font-size: 5em;"></i></a>
                    </div>
                </div>
            </aside>
        </section>
    </div>
    <div class="col-lg-6">
        <section class="panel post-wrap pro-box">
            <aside style="border: 1px solid #f1f2f7;">
                <div class="post-info">
                    <span class="arrow-pro right"></span>
                    <div class="panel-body">
                        <h1><strong>Footer</strong> <br> Настройка сайта</h1>
                        <div class="desk yellow">
                            <p></p>
                            <p>Перед началом работы необходимо создать <a href="/blocks/setting/update?id=8" style="text-decoration: underline;">блок</a> в разделе <a href="/blocks/setting" style="text-decoration: underline;">Настройка</a> и добавить в него необходимые поля</p>
                        </div>
                    </div>
                </div>
            </aside>
            <aside class="post-highlight terques v-align">
                <div class="panel-body text-center">
                    <div class="pro-thumb_">
                        <a href="/settings/header"><i class="far fa-hand-point-down" style="font-size: 5em;"></i></a>
                    </div>
                </div>
            </aside>
        </section>
    </div>
</div>