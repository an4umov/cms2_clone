<?php

use yii\bootstrap\Modal;

Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => ['label' => 'click me'],
]);

echo 'Say hello...';

Modal::end();