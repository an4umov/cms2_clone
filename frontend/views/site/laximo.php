<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


use guayaquil\guayaquillib\data\GuayaquilRequestOEM;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Laximo';
$this->params['breadcrumbs'][] = $this->title;

//include(Yii::getAlias('@vendor').DIRECTORY_SEPARATOR.'laximo'.DIRECTORY_SEPARATOR.'guayaquillib'.DIRECTORY_SEPARATOR.'com_guayaquil'.DIRECTORY_SEPARATOR.'guayaquillib'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'request.php');
// Подключаем класс для отображения данных со списком каталогов
//include('guayaquillib'.DIRECTORY_SEPARATOR.'render'.DIRECTORY_SEPARATOR.'catalogs'.DIRECTORY_SEPARATOR.'2coltable.php');


$catalogCode = 'AU1221';
$vin = 'WAUZZZ4M0HD042149';
/*
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






// Создаем объект для работы с сервисом
$request = new GuayaquilRequestOEM('', '', 'ru_RU');

// Используем логин и ключ для авторизации и аутентификации
$request->setUserAuthorizationMethod('ru241341', '3uxHTz3UVn3y');

// Добавляем в запрос команду запроса списка каталогов, доступных для пользователя
$request->appendListCatalogs();

// Выполняем запрос
$data = $request->query();

// Если произошла ошибка
if ($request->error != '')
{
    echo $request->error;
}
else
{
    // Создается объект для отображения данных каталога, которому передается объект класса  GuayaquilExtender (см. примечание)
    $renderer = new \guayaquil\guayaquillib\objects\CatalogListObject(new GuayaquilExtender());

    // Конфигурируем
    $renderer->columns = array('icon', 'name', 'version');

    // Отображаем полученные от сервиса данные
    echo $renderer->Draw($data->ListCatalogs);
}
*/
