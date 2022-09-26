<?php

/* @var $this yii\web\View */
/* @var $isPost bool */
/* @var $article string */
/* @var $errorMessage string */
/* @var $title string */
/* @var $priceFrom integer */
/* @var $priceTo integer */
/* @var $countFrom integer */
/* @var $countTo integer */
/* @var $number integer */
/* @var $result \Manticoresearch\ResultSet */

use guayaquil\guayaquillib\data\GuayaquilRequestOEM;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Price';
$this->params['breadcrumbs'][] = $this->title;
?>
<? if ($errorMessage): ?>
    <div class="alert alert-danger" role="alert">
        <?= $errorMessage ?>
    </div>
<? endif; ?>
<h4 class="mb-3">Фильтр поиска</h4>
<?php $form = ActiveForm::begin(['id' => 'form-search', 'method' => 'post',]); ?>
    <div class="row g-3">
        <div class="col-sm-5">
            <label for="article-field" class="form-label">Артикул</label>
            <input type="text" class="form-control" id="article-field" name="article" value="<?= $article ?>" placeholder="Поиск по частичному или полному значению">
        </div>
        <div class="col-sm-5">
            <label for="title-field" class="form-label">Наименование</label>
            <input type="text" class="form-control" id="title-field" name="title" value="<?= $title ?>" placeholder="Поиск по названию и описанию товара">
        </div>
    </div>
    <div class="row gy-3">
        <div class="col-md-3">
            <label for="price-from-field" class="form-label">Цена, от</label>
            <input type="number" class="form-control" id="price-from-field" name="price_from" value="<?= $priceFrom ?>">
        </div>

        <div class="col-md-3">
            <label for="price-to-field" class="form-label">до</label>
            <input type="number" class="form-control" id="price-to-field" name="price_to"  value="<?= $priceTo ?>">
        </div>
    </div>
    <div class="row gy-3">
        <div class="col-md-3">
            <label for="price-from-field" class="form-label">Количество, от</label>
            <input type="number" class="form-control" id="price-from-field" name="count_from" value="<?= $countFrom ?>">
        </div>

        <div class="col-md-3">
            <label for="price-to-field" class="form-label">до</label>
            <input type="number" class="form-control" id="price-to-field" name="count_to" value="<?= $countTo ?>">
        </div>

        <div class="col-md-3">
            <label for="number" class="form-label">На странице</label>
            <select class="form-select" id="number" name="number">
                <option value="15" <?= $number == 15 ? 'selected' : '' ?>>15</option>
                <option value="30" <?= $number == 30 ? 'selected' : '' ?>>30</option>
                <option value="100" <?= $number == 100 ? 'selected' : '' ?>>100</option>
                <option value="300" <?= $number == 300 ? 'selected' : '' ?>>300</option>
            </select>
            <div class="invalid-feedback">
                Please provide a valid state.
            </div>
        </div>
    </div>
    <hr class="my-4">
    <button class="w-100 btn btn-primary btn-lg" type="submit">Поиск</button>
<?php ActiveForm::end(); ?>

<? if ($isPost && empty($errorMessage)): ?>
<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
    <div class="lh-1">
        <h1 class="h6 mb-0 text-white lh-1">Результат поиска</h1>
        <small>Найдено / показано: <?= $result->getTotal() ?> / <?= $result->count() ?></small>
    </div>
</div>
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">Товары</h6>

    <? foreach ($result as $hit): ?>
    <? $data = $hit->getData() ?>
    <? //print_r($data) ?>
    <div class="d-flex text-muted border-bottom">
        <p class="small">
            <strong class="d-block text-gray-dark"><?= $hit->getId() ?> | <?= $data['article'] ?> | <?= $data['name'] ?></strong>
            <em>Цена: <?= $data['price1'] ?>, количество: <?= $data['count'] ?> </em>
        </p>
        <p class=""><?= $data['description'] ?></p>
    </div>
    <? endforeach; ?>
</div>
<? endif; ?>