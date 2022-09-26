<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $allCatalogs array */
/* @var $catalogInfo array */
/* @var $quickGroupsTree array */
/* @var $categoriesTree array */
/* @var $errors array */
/* @var $catalogCode string */
/* @var $vin string */


use guayaquil\guayaquillib\data\GuayaquilRequestOEM;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Laximo';
$this->params['breadcrumbs'][] = $this->title;

//include(Yii::getAlias('@vendor').DIRECTORY_SEPARATOR.'laximo'.DIRECTORY_SEPARATOR.'guayaquillib'.DIRECTORY_SEPARATOR.'com_guayaquil'.DIRECTORY_SEPARATOR.'guayaquillib'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'request.php');
// Подключаем класс для отображения данных со списком каталогов
//include('guayaquillib'.DIRECTORY_SEPARATOR.'render'.DIRECTORY_SEPARATOR.'catalogs'.DIRECTORY_SEPARATOR.'2coltable.php');

/*
$catalogCode = 'AU1221';
$vin = 'WAUZZZ4M0HD042149';

$request = new GuayaquilRequestOEM($catalogCode, '', 'ru_RU');
$request->setUserAuthorizationMethod('ru241341', '3uxHTz3UVn3y');
$request->appendGetCatalogInfo();
$request->appendFindVehicleByVIN($vin);
$data = $request->query();

// Если произошла ошибка
if ($request->error != '')
{
    echo $request->error;
}
else
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

*/
?>
<? if ($errors): ?>
    <pre><? print_r($errors) ?></pre>
<? endif; ?>
<h2 style="margin-top: 50px; color: darkred;">$allCatalogs</h2>
<pre><? print_r($allCatalogs) ?></pre>
<hr>
<h2 style="margin-top: 50px; color: darkred;">$catalogInfo by <?= $catalogCode ?></h2>
<pre><? print_r($catalogInfo) ?></pre>
<hr>
<h2 style="margin-top: 50px; color: darkred;">$quickGroupsTree by <?= $catalogCode ?> and VIN <?= $vin ?></h2>
<pre><? print_r($quickGroupsTree) ?></pre>
<hr>
<h2 style="margin-top: 50px; color: darkred;">$categoriesTree by <?= $catalogCode ?> and VIN <?= $vin ?></h2>
<pre><? print_r($categoriesTree) ?></pre>
