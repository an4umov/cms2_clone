<?php

use \common\components\helpers\ContentHelper;

/* @var $this yii\web\View */

?>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Параметр</th>
            <th scope="col">Описание</th>
            <th scope="col">Пример</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row"><?= ContentHelper::MACRO_TEXT ?></th>
        <td>Текст кнопки</td>
        <td>Нажми меня</td>
    </tr>
    <tr>
        <th scope="row"><?= ContentHelper::MACRO_BTN_BG_COLOR ?></th>
        <td>Цвет заливки прямоугольника</td>
        <td>#0E3E6A или red</td>
    </tr>
    <tr>
        <th scope="row"><?= ContentHelper::MACRO_BTN_BORDER_COLOR ?></th>
        <td>Цвет рамки прямоугольника</td>
        <td>#0E3E6A или black</td>
    </tr>
    <tr>
        <th scope="row"><?= ContentHelper::MACRO_BTN_TEXT_COLOR ?></th>
        <td>Цвет текста кнопки</td>
        <td>#004C56 или darkgreen</td>
    </tr>
    <tr>
        <th scope="row"><?= ContentHelper::MACRO_TARGET ?></th>
        <td>Способ открытия ссылки</td>
        <td>_blank, _self, _parent, _top</td>
    </tr>
    <tr>
        <th scope="row"><?= ContentHelper::MACRO_BTN_FA_CLASS ?></th>
        <td>Класс иконки шрифта Font Awesome. Будет показана перед текстом кнопки</td>
        <td>fas fa-calendar-alt, fas fa-address-card, fas fa-clock</td>
    </tr>
    <tr>
        <th scope="row"><?= ContentHelper::MACRO_LINK ?></th>
        <td>Ссылка при нажатии на кнопку</td>
        <td>http://ya.ru или /news/13</td>
    </tr>
    <tr>
        <th scope="row"><?= ContentHelper::MACRO_DIALOG_ID ?></th>
        <td>ID вызываемой модальной формы</td>
        <td><i class="fas fa-question-circle"></i></td>
    </tr>
    </tbody>
</table>
<hr>
<div class="card">
    <div class="card-body">
        <strong>Пример кода для вставки</strong><br><br>
        <code>{{{<?= ContentHelper::MACRO_TEXT ?>="Текст кнопки" <?= ContentHelper::MACRO_TARGET ?>="_blank"  <?= ContentHelper::MACRO_BTN_FA_CLASS ?>="fas fa-star-of-life" <?= ContentHelper::MACRO_BTN_BG_COLOR ?>="red" <?= ContentHelper::MACRO_BTN_BORDER_COLOR ?>="green" <?= ContentHelper::MACRO_BTN_TEXT_COLOR ?>="white" <?= ContentHelper::MACRO_LINK ?>="http://ya.ru"}}}</code><br><br>
        <code>{{{text="Дави батон!" btnBgColor="navy" btnTextColor="white" dialogID="<Непонятно пока что...>"}}}</code>
    </div>
</div>