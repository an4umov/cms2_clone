<?php
/**
 * @var \common\models\Articles $model
 * @var array $data
 */

use \yii\helpers\Html;

if ($data): ?>
    <div class="row marginlr">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <h4 class="background5">товар входит в следующие разделы интернет магазина</h4>
        </div>
    </div>
    <? foreach ($data as $code => $breadcrumbs): ?>
    <div class="row table0">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 product_filter">
        <?
        foreach ($breadcrumbs as $i => $breadcrumb){
            $index = $i + 1;

            if ($index === count($breadcrumbs)) {
                echo ' '.Html::tag('span', Html::tag('i', '', ['class' => 'fas fa-angle-double-right',]));
            }

            echo ' '.Html::a($breadcrumb['label'], $breadcrumb['url']);

            if (($index + 1) < count($breadcrumbs)) {
                echo ' '.Html::tag('span', '•');
            }
        }
        ?>
        </div>
    </div>
    <? endforeach; ?>
<? endif; ?>
