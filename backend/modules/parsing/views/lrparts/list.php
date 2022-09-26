<?php
/* @var $this yii\web\View */
/* @var $blocks array */
/* @var $content \common\models\Content */

if ($blocks) {
    $index = 1;
    foreach ($blocks as $block) {
        echo \backend\components\widgets\ContentBlockWidget::widget(['block' => $block, 'index' => $index++, 'isContent' => false, 'content' => null, 'isAjax' => true,]);
    }
} else {
    echo \yii\helpers\Html::tag('p', 'Нет данных') ;
}

$js = '
$(".popover-dismiss").popover({
  trigger: "focus"
})
';
$this->registerJs($js, $this::POS_READY);