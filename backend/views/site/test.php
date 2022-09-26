<?php

/* @var $data array */

$this->title = 'Панель управления / Тест';
$this->params['breadcrumbs'][] = $this->title;

?>


<h1>TEST</h1>
<pre>
<? print_r(\common\components\helpers\BlockHelper::getContentManufacturersList()) ?>
</pre>