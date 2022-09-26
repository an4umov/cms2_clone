<?php

/**
 * @var \yii\web\View $this
 * @var \devanych\cart\Cart $cart
 * @var $item \devanych\cart\CartItem
 */

$this->title = 'Оформление заказа';
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/cart',], 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'template' => \common\components\helpers\CatalogHelper::BREADCRUMB_TEMPLATE,];

use yii\helpers\Url;
$isEmpty = empty($cartItems = $cart->getItems());
?>
<div class="container mycontainer">
<?php if(!$isEmpty): ?>
    <ul class="nav pay-tabs-list mb-3 mt-3 justify-content-center" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user" aria-selected="true">ДАННЫЕ ПОКУПАТЕЛЯ<i class="fa fa-arrow-alt-circle-right" aria-hidden="true"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-production-method-tab" data-toggle="pill" href="#pills-production-method" role="tab" aria-controls="pills-production-method" aria-selected="false">СПОСОБ ПОЛУЧЕНИЯ<i class="fa fa-arrow-alt-circle-right" aria-hidden="true"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-pay-method-tab" data-toggle="pill" href="#pills-pay-method" role="tab" aria-controls="pills-pay-method" aria-selected="false">СПОСОБ ОПЛАТЫ<i class="fa fa-arrow-alt-circle-right" aria-hidden="true"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">ПОДТВЕРДИТЬ И ОТПРАВИТЬ<i class="fa fa-arrow-alt-circle-right" aria-hidden="true"></i></a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade pills-user-tab show active" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
            <div class="row mb-3">
                <div class="col-12 d-flex align-items-center">
                    <h4 class="m-0 mr-4">НОВЫЙ ПОКУПАТЕЛЬ</h4>
                    <p class="m-0">Уже покупали у нас ранее?<a href="#" target="_blank" rel="noopener noreferrer"> Войдите в
                            личный кабинет</a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-8  d-flex flex-wrap">
                    <label for="" class="tabs-label">
                        E-mail
                        <input type="email" placeholder="Введите E-mail">
                    </label>
                    <label for="" class="tabs-label">
                        Телефон
                        <input type="tel" placeholder="Введите телефон">
                    </label>
                    <label for="" class="tabs-label">
                        Имя
                        <input type="text" placeholder="Введите Имя">
                    </label>
                </div>
                <div class="col-lg-12 col-md-12 mt-4 mb-4 col-sm-12 d-flex flex-wrap" >
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="customRadioInline1" checked
                               class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline1">ПокупАТЕЛЬ - ФИЗИЧЕСКОЕ ЛИЦо</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline2">ПокупАТЕЛЬ - ИНДИВИДУАЛЬНЫЙ
                            ПРЕДПРИНИМАТЕЛЬ</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input">
                        <label class="custom-control-label" for="customRadioInline3">ПокупАТЕЛЬ - ЮРИДИЧЕСКОЕ лИЦО</label>
                    </div>
                </div>
                <div class="col-12 col-lg-7 col-sm-12 d-flex flex-wrap">
                    <div class="col-12 col-lg-8">
                        <label for="" class="tabs-label">
                            ИНН
                            <input type="email" placeholder="Введите ИНН">
                        </label>
                        <label for="" class="tabs-label">
                            КПП
                            <input type="tel" placeholder="Введите КПП">
                        </label>
                        <label for="" class="tabs-label">
                            НАИМЕНОВАННИЕ
                            <input type="text" placeholder="Введите Наименование">
                        </label>
                    </div>
                    <div class="col-12 col-lg-3">
                        <button class="btn" type="submit">ИСКАТЬ</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade pills-production-method" id="pills-production-method" role="tabpanel"
             aria-labelledby="pills-production-method-tab">
            <div class="row">
                <div class="col-12">
                    <h4>Как вы хотите получить товар:</h4>
                    <ul class="nav nav-pills delivery-method-list d-flex justify-content-between flex-wrap mb-3" id="pills-tab"
                        role="tablist">
                        <li class="nav-item mb-3">
                            <a class="nav-link active" id="pills-self-tab" data-toggle="pill" href="#pills-self" role="tab"
                               aria-controls="pills-self" aria-selected="true">
                                <i class="fas fa-people-carry "></i>
                                <div class="text">
                                    <h4>Заберу сам в москве</h4>
                                    <p>самовывоз из магазина или пакомат</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mb-3">
                            <a class="nav-link" id="pills-delivery-moscow-tab" data-toggle="pill" href="#pills-delivery-moscow"
                               role="tab" aria-controls="pills-delivery-moscow" aria-selected="false">
                                <i class="fas fa-dolly "></i>
                                <div class="text">
                                    <h4>Доставка по Москве</h4>
                                    <p>курьер до двери</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mb-3">
                            <a class="nav-link" id="pills-country-delivery-tab" data-toggle="pill" href="#pills-country-delivery"
                               role="tab" aria-controls="pills-country-delivery" aria-selected="false">
                                <i class="fas fa-shipping-fast "></i>
                                <div class="text">
                                    <h4>доставка по России</h4>
                                    <p>транспортные компании, почта, курьер</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mb-3">
                            <a class="nav-link" id="pills-world-delivery-tab" data-toggle="pill" href="#world-delivery" role="tab"
                               aria-controls="pills-world-delivery" aria-selected="false">
                                <i class="fas fa-plane-departure "></i>
                                <div class="text">
                                    <h4>доставка по миру</h4>
                                    <p>доставка за пределы россии</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-self" role="tabpanel" aria-labelledby="pills-self-tab">
                            <h5>ЗАБРАТЬ ВАШ заказ вы можете по адресу москва дорогобужская ул 14 график работы </h5>
                            <iframe
                                    src="https://yandex.ru/map-widget/v1/?um=constructor%3Aa8bd73e9bf382b9feca219aefbf01c8275b5e30073973594aaba30bb79923d5d&amp;source=constructor"
                                    width="100%" height="400" frameborder="0"></iframe>

                        </div>
                        <div class="tab-pane fade" id="pills-delivery-moscow" role="tabpanel"
                             aria-labelledby="pills-delivery-moscow-tab">
                            <div class="row">
                                <div class="col-5 d-flex flex-wrap">
                                    <label for="" class="tabs-label">
                                        Улица, дом
                                        <input type="text" placeholder="Улица, дом">
                                    </label>
                                    <label for="" class="tabs-label">
                                        Время
                                        <input type="time" name="" id="">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-country-delivery" role="tabpanel"
                             aria-labelledby="pills-country-delivery-tab">
                            <div class="row">
                                <div class="col">
                                    <h3>хотите выбрать транспортную компанию?</h3>
                                    <ul class="nav nav-pills delivery-method-list mb-3 d-flex justify-content-between flex-wrap"
                                        id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                                               aria-controls="pills-home" aria-selected="true">
                                                <div class="text">
                                                    <h4>доставка по России</h4>
                                                    <p>транспортные компании, почта, курьер</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                                               aria-controls="pills-home" aria-selected="true">
                                                <div class="text">
                                                    <h4>доставка по России</h4>
                                                    <p>транспортные компании, почта, курьер</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                             aria-labelledby="pills-home-tab">
                                            <div class="check-delivery-calculation">
                                                <div class="row marginlr">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <h3>Параметры посылки для расчёта доставки</h3>
                                                    </div>
                                                    <div
                                                            class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 d-flex flex-wrap  justify-content-end">
                                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3">
                                                            Вес общий брутто, кг
                                                        </div>
                                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <div class="form-group">
                                                                <input type="quantity" class="form-control" id="exampleInputquantity"
                                                                       aria-describedby="quantityHelp" placeholder="XXXX">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3">
                                                            стоимость, <i class="fas fa-ruble-sign"></i>
                                                        </div>
                                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <div class="form-group">
                                                                <input type="quantity" class="form-control" id="exampleInputquantity"
                                                                       aria-describedby="quantityHelp" placeholder="XXXX">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                            class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 d-flex flex-wrap  justify-content-start">
                                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3">
                                                            Размер посылки, см
                                                        </div>
                                                        <div class="col-4 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                            <div class="form-group">
                                                                <input type="quantity" class="form-control" id="exampleInputquantity"
                                                                       aria-describedby="quantityHelp" placeholder="XXXX">
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                            <div class="form-group">
                                                                <input type="quantity" class="form-control" id="exampleInputquantity"
                                                                       aria-describedby="quantityHelp" placeholder="XXXX">
                                                            </div>
                                                        </div>
                                                        <div class="col-4 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                                            <div class="form-group">
                                                                <input type="quantity" class="form-control" id="exampleInputquantity"
                                                                       aria-describedby="quantityHelp" placeholder="XXXX">
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 mb-3">
                                                            объем посылки куб.м
                                                        </div>
                                                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                            <div class="form-group">
                                                                <input type="quantity" class="form-control" id="exampleInputquantity"
                                                                       aria-describedby="quantityHelp" placeholder="XXXX">
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 buttons">
                                                        <button class="button1"><i class="fas fa-calculator"></i> расчитать доставку</button>
                                                        <button class="button2"><i class="fas fa-sync-alt"></i> обновить данные</button>
                                                    </div>




                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <p>К СОЖАЛЕНИЮ, СЕЙЧАС У НАС НЕТ ВСЕЙ НЕОБХОДИМОЙ ИНФОРМАЦИИ ДЛЯ АВТОМАТИЧЕСКОГО РАСЧЕТА
                                                            СТОИМОСТИ ДОСТАВКИ ПО
                                                            КАЛЬКУЛЯТОРАМ ТРАНСПОРТНЫХ КОМПАНИЙ. НАШИ МЕНЕДЖЕРЫ ПОМОГУТ РАСЧИТАТЬ СТОИМОСТЬ ДОСТАВКИ
                                                            В РУЧНОМ РЕЖИМЕ.</p>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="shipping-methods">
                                                <div class="row marginlr">
                                                    <div class="col-12">
                                                        <div class="bl1">
                                                            <div class="image"><img src="img/shipm1.png" alt=""></div>
                                                            <div class="text">
                                                                <h4>транспортная компания “пэк”</h4>
                                                                <p>Текст о описание курьервской доставки Текст о описание курьервской доставки Текст о
                                                                    описание курьервской
                                                                    достав ки Текст о описание курьервской доставки курьервской достав ки Текст о
                                                                    описание курьервской
                                                                    доставки курьервской достав ки Текст о описание курьервской доставки</p>
                                                                <div class="readmore"><a href="">подробнее <i
                                                                                class="fas fa-angle-double-right"></i></a></div>
                                                            </div>
                                                        </div>
                                                        <div class="bl2">
                                                            <h4>Выберите вариант доставки</h4>
                                                            <div class="form-check check1 custom-control custom-checkbox">
                                                                <input type="checkbox" class="form-check-input custom-control-input" id="dopcheck3">
                                                                <label class="form-check-label form-check-label custom-control-label" for="dopcheck3">
                                                                    <h5>доставка со склада ТК - 350 <i class="fas fa-ruble-sign"></i>, срок <span>3
                                        дня</span></h5>
                                                                    <div class="text0">Вы сами забираете товар со склада транспортной компании в Вашем
                                                                        городе</div>
                                                                </label>
                                                            </div>
                                                            <div class="form-check check1 custom-control custom-checkbox">
                                                                <input type="checkbox" class="form-check-input custom-control-input" id="dopcheck4">
                                                                <label class="form-check-label form-check-label custom-control-label" for="dopcheck4">
                                                                    <h5>доставка курьером до двери - 500 <i class="fas fa-ruble-sign"></i>, срок <span>3
                                        дня</span></h5>
                                                                    <div class="text0">Курьер привезет к Вам по указаному адресу</div>
                                                                </label>
                                                            </div>
                                                            <div class="warning">Предупреждение! Данные могут корректироваться</div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="mt-5 delivery-address">
                                                <div class="row marginlr">
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <h3>Адрес доставки</h3>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <div class="form-group">
                                                            <label for="">Адрес (*)</label>
                                                            <input type="quantity" class="form-control" id="exampleInputquantity" aria-describedby="quantityHelp" placeholder="Введите ваш полный адрес">
                                                            <span>Примечание! При заопнении адреса указывайте пожалуйста город село район и улицу </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="">Фамилия Имя Отчество <span>(*)</span></label>
                                                            <input type="quantity" class="form-control" id="exampleInputquantity" aria-describedby="quantityHelp" placeholder="Введите свое ФИО">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="">E-mail <span>(*)</span></label>
                                                            <input type="quantity" class="form-control" id="exampleInputquantity" aria-describedby="quantityHelp" placeholder="Введите ваш электронный адрес">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="">Домашний телефон <span>(*)</span></label>
                                                            <input type="quantity" class="form-control" id="exampleInputquantity" aria-describedby="quantityHelp" placeholder="8 (XXX) XX-XX-XXXX">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="">Рабочий телефон</label>
                                                            <input type="quantity" class="form-control" id="exampleInputquantity" aria-describedby="quantityHelp" placeholder="8 (XXX) XX-XX-XXXX">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Комментарий</label>
                                                            <textarea placeholder="Введите время доставки и другие пожелания" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-world-delivery" role="tabpanel"
                             aria-labelledby="pills-world-delivery-tab">...</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade pills-pay-method" id="pills-pay-method" role="tabpanel"
             aria-labelledby="pills-pay-method-tab">
            <div class="container mycontainer shipping-methods">
                <div class="row marginlr">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="bl1">
                            <div class="image"><img src="img/visa.jpg" alt=""></div>
                            <div class="text">
                                <h4>транспортная компания “пэк”</h4>
                                <p>Текст о описание курьервской доставки Текст о описание курьервской доставки Текст о описание
                                    курьервской
                                    достав ки Текст о описание курьервской доставки курьервской достав ки Текст о описание курьервской
                                    доставки курьервской достав ки Текст о описание курьервской доставки</p>
                                <div class="readmore"><a href="">подробнее <i class="fas fa-angle-double-right"></i></a></div>
                            </div>
                        </div>
                        <div class="bl2">
                            <div class="form-check check1 custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input custom-control-input" id="dopcheck3">
                                <label class="form-check-label form-check-label custom-control-label" for="dopcheck3">
                                    <p>ВЫБРАТЬ ЭТОТ ВАРИАНТ ОПЛАТЫ</p></br>
                                    <span>Вы получите инструкции по оплате после обработки заказа нашим менеджером</span>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="tab-pane fade pills-contact" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <section class="main-cart">
                <div class="row">
                    <table class="table table-hover cart-table">
                        <tbody>
                        <?php foreach($cartItems as $item): ?>
                            <tr>
                                <td class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 order-md-1 order-1 text-md-center"><a href="<?= Url::to(['shop/code', 'code' => $item->getProduct()->product_code,])?>"><?= $item->getProduct()->product_name ?></a></td>
                                <td class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 order-md-2 order-3  text-md-center">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="company-name">EUROSPARE</span>
                                        <span class="company-name-second ml-1">GENUINE</span>
                                    </div>
                                </td>
                                <td class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 order-md-3 order-lg-2 order-3 text-md-center">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="part-replacement">Замена</span>
                                        <small class="ml-1">ERR3340</small>
                                    </div>
                                </td>
                                <td class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 order-sm-7 order-md-7 order-lg-3 order-4 text-md-center">
                                    <span class="price"><?= $item->getPrice() ?><i class="fas fa-ruble-sign"></i></span>
                                </td>
                                <td class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 order-md-4 order-lg-4 order-2 text-left  text-lg-center text-md-center text-sm-left">
                                    <div class="d-flex flex-column">
                                        <span class="product-availability">В наличии</span>
                                    </div>
                                </td>
                                <td class="col-6 col-sm-6 col-md-4 col-lg-2 col-xl-2 order-sm-5 order-md-6 order-lg-5 order-5 text-lg-center text-left text-md-center text-sm-left">
                                    <span class="product-amount"><?= $item->getQuantity() ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row border-bottom">
                    <div class="col-6 mb-3">
                        <span class="cart-title">ВСЕГО</span>
                    </div>
                    <div class="col-6 mb-3 text-right">
                        <span class="cart-value"><?=$cart->getTotalCost() ?></span>
                    </div>
                    <div class=" col-6 col-lg-2 mb-3 d-flex flex-wrap align-items-center justify-content-between">
                        <span class="cart-title">СКИДКА</span>
                        <span class="cart-sale">10</span>
                    </div>
                    <div class="col-6 col-lg-10 mb-3 text-right">
                        <span class="cart-value">1677</span>
                    </div>
                    <div class="col-6  d-flex flex-wrap justify-content-between">
                        <span class="cart-title">СКИДКА ПО КУПОНУ</span>
                    </div>
                    <div class="col-6  text-right">
                        <span class="cart-value">-100</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex flex-column align-items-start mt-3 justify-content-between">
                        <span class="cart-title mb-3">ИТОГО</span>

                    </div>
                    <div class="col d-flex flex-column text-right align-items-end mt-3">
                        <span class="cart-value mb-3">15 677</span>
                    </div>
                </div>
                <div class="row d-flex flex-column">
                    <h5>ДАННЫЕ О ПОКУПАТЕЛЕ </h5>
                    <ul>
                        <li>Имя Фамилия<span>Пупкин Василий</span></li>
                        <li>Телефон<span>Телефон: </span></li>
                        <li>E-mail<span>ya@ya.ru</span></li>
                        <li>Покупатель<span> Физическое лицо</span></li>
                    </ul>
                    <h5>СПОСОБ ПОЛУЧЕНИЯ ТОВАРОВ</h5>
                    <ul>
                        <li>Способ доставки<span>Отправка пранспортной компанией по РФ</span></li>
                        <li>Выбранная компания<span>ПЭК, доставка до терминала</span></li>
                        <li>Способ доставки<span>Отправка пранспортной компанией по РФ</span></li>
                    </ul>
                    <h5>СПОСОБ ПОЛУЧЕНИЯ ТОВАРОВ</h5>
                    <ul>
                        <li>Способ оплаты <span>Платежным поручением через банк</span></li>
                    </ul>
                </div>
            </section>
        </div>
    </div>
<?php else:?>
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        Корзина пуста
    </div>
<?php endif;?>
</div>
