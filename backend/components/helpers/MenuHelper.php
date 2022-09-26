<?php
namespace backend\components\helpers;

use common\models\Block;
use yii;
use yii\bootstrap\Nav;
use yii\helpers\Html;

class MenuHelper
{
    const FIRST_MENU_HOME_PAGE = 'home';
    const FIRST_MENU_PAGES = 'pages';
    const FIRST_MENU_ARTICLES = 'articles';
    const FIRST_MENU_NEWS = 'news';
    const FIRST_MENU_BLOCKS = 'blocks';
    const FIRST_MENU_STRUCTURES = 'structures';
    const FIRST_MENU_PARSING = 'parsing';
    const FIRST_MENU_CART = 'cart';
    const FIRST_MENU_CONTENT = 'content';
    const FIRST_MENU_SETTINGS = 'settings';
    const FIRST_MENU_ADMIN = 'admin';
    const FIRST_MENU_SENDED = 'sended';
    const FIRST_MENU_REFERENCES = 'references';

    const SECOND_MENU_CONTENT_PAGES = 'pages';
    const SECOND_MENU_CONTENT_ARTICLES = 'articles';
    const SECOND_MENU_CONTENT_NEWS = 'news';
    const SECOND_MENU_CONTENT_TREE = 'tree';

    const SECOND_MENU_BLOCKS_BLOCK_READY = 'ready';
    const SECOND_MENU_BLOCKS_COMMON = 'common';
    const SECOND_MENU_BLOCKS_AGGREGATOR = 'aggregator';
    const SECOND_MENU_BLOCKS_FORMS = 'form';

    const THIRD_MENU_BLOCKS_GALLERY = 'gallery';
    const THIRD_MENU_BLOCKS_TEXT = 'text';
    const THIRD_MENU_BLOCKS_BANNER = 'banner';
    const THIRD_MENU_BLOCKS_SLIDER = 'slider';
    const THIRD_MENU_BLOCKS_FILTER = 'filter';
    const THIRD_MENU_BLOCKS_SETTING = 'setting';

    const SECOND_MENU_STRUCTURES_DEPARTMENT = 'department';
    const SECOND_MENU_STRUCTURES_CATALOG_LINKTAG_DEPARTMENT = 'catalog-linktag-department';
    const SECOND_MENU_STRUCTURES_MENU = 'department-menu';
    const SECOND_MENU_STRUCTURES_TREE = 'department-tree';
    const SECOND_MENU_STRUCTURES_MODEL = 'department-model';
    const SECOND_MENU_STRUCTURES_TAG = 'custom-tag';
    const SECOND_MENU_STRUCTURES_REFERENCE = 'reference';

    const SECOND_MENU_PARSING_LRPARTS = 'lrparts';

    const SECOND_MENU_REFERENCES_PARTNER = 'partner';
    const SECOND_MENU_REFERENCES_BUYER = 'buyer';
    const SECOND_MENU_REFERENCES_DELIVERY = 'delivery';
    const SECOND_MENU_REFERENCES_DELIVERY_GROUP = 'delivery-group';
    const SECOND_MENU_REFERENCES_PAYMENT = 'payment';
    const SECOND_MENU_REFERENCES_PAYMENT_GROUP = 'payment-group';
    const SECOND_MENU_REFERENCES_REFERENCE = 'reference';
    const SECOND_MENU_REFERENCES_PROVERKACHEKA = 'proverkacheka';

    const SECOND_MENU_SETTINGS_HEADER = 'header';
    const SECOND_MENU_SETTINGS_FOOTER = 'settings-footer';
    const SECOND_MENU_SETTINGS_CART_SETTINGS = 'cart-settings';
    const SECOND_MENU_SETTINGS_FOOTER_ITEM = 'settings-footer-item';
    const SECOND_MENU_SETTINGS_NEWS = 'news';
    const SECOND_MENU_SETTINGS_MACRO = 'macro';
    const SECOND_MENU_SETTINGS_CHECKOUT = 'settings-checkout';
    const SECOND_MENU_SETTINGS_ICON_MAIN_SHOP_LEVEL = 'shop';
    const SECOND_MENU_SETTINGS_MIGRATION = 'migration';
    const SECOND_MENU_SETTINGS_LK = 'lk';
    const SECOND_MENU_SETTINGS_MAILING = 'mailing';
    const SECOND_MENU_SETTINGS_GREEN_MENU = 'green-menu';

    const SECOND_MENU_ADMIN_MANAGERS = 'managers';
    const SECOND_MENU_ADMIN_TRASH = 'trash';
    const SECOND_MENU_ADMIN_ORDERS = 'order';

    const SECOND_MENU_SENDED_FORM = 'form-sended';
    const SECOND_MENU_SENDED_QUESTION = 'question-sended';

    /**
     * @param string $activeMenu
     *
     * @return string
     * @throws \Exception
     */
    public static function firstMenuLevel(string $activeMenu, string $activeSecondMenu) : string
    {
        if (!Yii::$app->user->isGuest) {
//            $block = new Block();
            $model = new Block();
            $items = [
                ['label' => IconHelper::getSpanIcon(IconHelper::ICON_STRUCTURES).' Структура', 'url' => ['/'.self::FIRST_MENU_STRUCTURES,], 'active' => $activeMenu === self::FIRST_MENU_STRUCTURES, 'dropDownOptions' => ['id' => 'second-left-menu-widget', "class" => "nav"], 'items' => [
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT).' Департаменты', 'url' => ['/'.self::FIRST_MENU_STRUCTURES.'/'.self::SECOND_MENU_STRUCTURES_TREE,], 'active' => $activeSecondMenu === self::SECOND_MENU_STRUCTURES_TREE,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_LINKTAG_DEPARTMENT).' Ссылки на тег', 'url' => ['/'.self::SECOND_MENU_STRUCTURES_CATALOG_LINKTAG_DEPARTMENT,], 'active' => $activeSecondMenu === self::SECOND_MENU_STRUCTURES_CATALOG_LINKTAG_DEPARTMENT,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_GREEN_MENU).' Зеленое меню', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_GREEN_MENU,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_GREEN_MENU,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_TAGS).' Теги', 'url' => ['/'.self::FIRST_MENU_STRUCTURES.'/'.self::SECOND_MENU_STRUCTURES_TAG,], 'active' => $activeSecondMenu === self::SECOND_MENU_STRUCTURES_TAG,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_HEADER).' Header', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_HEADER,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_HEADER,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FOOTER).' Footer', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_FOOTER,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_FOOTER,],
                ]],
                ['label' => IconHelper::getSpanIcon(IconHelper::ICON_HOME_PAGE).' Контент', 'url' => ['/'.self::FIRST_MENU_CONTENT,], 'active' => $activeMenu === self::FIRST_MENU_CONTENT, 'dropDownOptions' => ['id' => 'second-left-menu-widget', "class" => "nav"], 'items' => [
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_PAGES).' Страницы', 'url' => ['/'.self::FIRST_MENU_CONTENT.'/'.self::SECOND_MENU_CONTENT_PAGES,], 'active' => $activeSecondMenu === self::SECOND_MENU_CONTENT_PAGES,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_NEWS).' Новости', 'url' => ['/'.self::FIRST_MENU_CONTENT.'/'.self::SECOND_MENU_CONTENT_NEWS,], 'active' => $activeSecondMenu === self::SECOND_MENU_CONTENT_NEWS,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_ARTICLES).' Статьи', 'url' => ['/'.self::FIRST_MENU_CONTENT.'/'.self::SECOND_MENU_CONTENT_ARTICLES,], 'active' => $activeSecondMenu === self::SECOND_MENU_CONTENT_ARTICLES,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT_TREE).' Дерево', 'url' => ['/'.self::FIRST_MENU_CONTENT.'/'.self::SECOND_MENU_CONTENT_TREE,], 'active' => $activeSecondMenu === self::SECOND_MENU_CONTENT_TREE,],
                ]],
                ['label' => IconHelper::getSpanIcon(IconHelper::ICON_BLOCKS).' Блоки', 'url' => ['/'.self::FIRST_MENU_BLOCKS,], 'active' => $activeMenu === self::FIRST_MENU_BLOCKS, 'dropDownOptions' => ['id' => 'second-left-menu-widget', "class" => "nav"], 'items' => [
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_BLOCKS).' Обычные блоки', 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_COMMON,], 'active' => $activeSecondMenu === self::SECOND_MENU_BLOCKS_COMMON,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_READY).' '.$model->getTypeTitle(Block::TYPE_BLOCK_READY), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_BLOCK_READY,], 'active' => $activeSecondMenu === self::SECOND_MENU_BLOCKS_BLOCK_READY,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_AGGREGATOR).' '.$model->getTypeTitle(Block::TYPE_AGGREGATOR), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_AGGREGATOR,], 'active' => $activeSecondMenu === self::SECOND_MENU_BLOCKS_AGGREGATOR,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FORM).' '.$model->getTypeTitle(Block::TYPE_FORM), 'url' => ['/'.self::SECOND_MENU_BLOCKS_FORMS,], 'active' => $activeSecondMenu === self::SECOND_MENU_BLOCKS_FORMS,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MACRO).' Макросы', 'url' => ['/'.self::SECOND_MENU_SETTINGS_MACRO,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_MACRO,],
                ]],
                ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SYSTEM_ADMIN).' Админ', 'url' => ['/'.self::FIRST_MENU_ADMIN,], 'active' => $activeMenu === self::FIRST_MENU_ADMIN, 'dropDownOptions' => ['id' => 'second-left-menu-widget', "class" => "nav"], 'items' => [
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_MODERATOR).' Менеджеры', 'url' => ['/'.self::SECOND_MENU_ADMIN_MANAGERS,], 'active' => $activeSecondMenu === self::SECOND_MENU_ADMIN_MANAGERS,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_QUESTIONS).' Вопросы', 'url' => ['/'.self::SECOND_MENU_SENDED_QUESTION,], 'active' => $activeSecondMenu === self::SECOND_MENU_SENDED_QUESTION,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FORM).' Формы', 'url' => ['/'.self::SECOND_MENU_SENDED_FORM,], 'active' => $activeSecondMenu === self::SECOND_MENU_SENDED_FORM,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_TRASH).' Корзина', 'url' => ['/'.self::SECOND_MENU_ADMIN_TRASH,], 'active' => $activeSecondMenu === self::SECOND_MENU_ADMIN_TRASH,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_ORDERS).' Заказы', 'url' => ['/'.self::SECOND_MENU_ADMIN_ORDERS,], 'active' => $activeSecondMenu === self::SECOND_MENU_ADMIN_ORDERS,],
                ]],
                ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SYSTEM_SETTINGS).' Настройки', 'url' => ['/'.self::FIRST_MENU_SETTINGS,], 'active' => $activeMenu === self::FIRST_MENU_SETTINGS, 'dropDownOptions' => ['id' => 'second-left-menu-widget', "class" => "nav"], 'items' => [
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_NEWS).' Агрегатор новостей', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_NEWS,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_NEWS,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_CHECKOUT).' Оформление заказа', 'url' => ['/'.self::SECOND_MENU_SETTINGS_CHECKOUT,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_CHECKOUT,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MAIN_SHOP_LEVEL).' Главный уровень магазинов', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_ICON_MAIN_SHOP_LEVEL,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_ICON_MAIN_SHOP_LEVEL,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MIGRATION).' Миграция БД', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_MIGRATION,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_MIGRATION,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_LK).' Личный кабинет', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_LK,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_LK,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MAILING).' Почтовые рассылки', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_MAILING,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_MAILING,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FOOTER).' Футер', 'url' => ['/'.self::SECOND_MENU_SETTINGS_FOOTER,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_FOOTER,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_CART).' Настройка корзины', 'url' => ['/'.self::FIRST_MENU_CART.'/'.self::SECOND_MENU_SETTINGS_CART_SETTINGS,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_CART_SETTINGS,],
                ]],
                
                ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE).' Справочники', 'url' => ['/'.self::FIRST_MENU_REFERENCES,], 'active' => $activeMenu === self::FIRST_MENU_REFERENCES, 'dropDownOptions' => ['id' => 'second-left-menu-widget', "class" => "nav"], 'items' => [
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PARTNER).' Партнеры', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PARTNER,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_PARTNER,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_BUYER).' Покупатели', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_BUYER,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_BUYER,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_DELIVERY).' Группы доставки', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_DELIVERY_GROUP,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_DELIVERY_GROUP,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_DELIVERY).' Доставка', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_DELIVERY,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_DELIVERY,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PAYMENT).' Группы оплаты', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PAYMENT_GROUP,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_PAYMENT_GROUP,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PAYMENT).' Оплата', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PAYMENT,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_PAYMENT,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE).' Обычные списки', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_REFERENCE,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_REFERENCE,],
                    ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PROVERKACHEKA).' Проверка чека', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PROVERKACHEKA,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_PROVERKACHEKA,],
                ]],

                ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SYSTEM_PARSING).' Парсинг', 'url' => ['/'.self::FIRST_MENU_PARSING,], 'active' => $activeMenu === self::FIRST_MENU_PARSING,],
            ];

            return Nav::widget([
                'id' => 'left-menu-widget',
                'options' => ['class' => '',],
                'items' => $items,
                'encodeLabels' => false,
            ]);
        }

        return '';
    }

    /**
     * @param string $activeMenu
     * @param string $activeSecondMenu
     *
     * @return string
     * @throws \Exception
     */
    public static function secondMenuLevel(string $activeMenu, string $activeSecondMenu) : string
    {
        $menu = '';
        if (!Yii::$app->user->isGuest) {
            $items = [];
            switch ($activeMenu) {
                case self::FIRST_MENU_STRUCTURES:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT).' Департаменты', 'url' => ['/'.self::FIRST_MENU_STRUCTURES.'/'.self::SECOND_MENU_STRUCTURES_TREE,], 'active' => $activeSecondMenu === self::SECOND_MENU_STRUCTURES_TREE,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_LINKTAG_DEPARTMENT).' Ссылки на тег', 'url' => ['/'.self::SECOND_MENU_STRUCTURES_CATALOG_LINKTAG_DEPARTMENT,], 'active' => $activeSecondMenu === self::SECOND_MENU_STRUCTURES_CATALOG_LINKTAG_DEPARTMENT,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_GREEN_MENU).' Зеленое меню', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_GREEN_MENU,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_GREEN_MENU,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_TAGS).' Теги', 'url' => ['/'.self::FIRST_MENU_STRUCTURES.'/'.self::SECOND_MENU_STRUCTURES_TAG,], 'active' => $activeSecondMenu === self::SECOND_MENU_STRUCTURES_TAG,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_HEADER).' Header', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_HEADER,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_HEADER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FOOTER).' Footer', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_FOOTER,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_FOOTER,],
                    ];
                    break;
                case self::FIRST_MENU_CONTENT:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_PAGES).' Страницы', 'url' => ['/'.self::FIRST_MENU_CONTENT.'/'.self::SECOND_MENU_CONTENT_PAGES,], 'active' => $activeSecondMenu === self::SECOND_MENU_CONTENT_PAGES,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_NEWS).' Новости', 'url' => ['/'.self::FIRST_MENU_CONTENT.'/'.self::SECOND_MENU_CONTENT_NEWS,], 'active' => $activeSecondMenu === self::SECOND_MENU_CONTENT_NEWS,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_ARTICLES).' Статьи', 'url' => ['/'.self::FIRST_MENU_CONTENT.'/'.self::SECOND_MENU_CONTENT_ARTICLES,], 'active' => $activeSecondMenu === self::SECOND_MENU_CONTENT_ARTICLES,],
                    ];
                    break;
                case self::FIRST_MENU_BLOCKS:
                    $model = new Block();
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_BLOCKS).' Обычные блоки', 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_COMMON,], 'active' => $activeSecondMenu === self::SECOND_MENU_BLOCKS_COMMON,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_READY).' '.$model->getTypeTitle(Block::TYPE_BLOCK_READY), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_BLOCK_READY,], 'active' => $activeSecondMenu === self::SECOND_MENU_BLOCKS_BLOCK_READY,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_AGGREGATOR).' '.$model->getTypeTitle(Block::TYPE_AGGREGATOR), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_AGGREGATOR,], 'active' => $activeSecondMenu === self::SECOND_MENU_BLOCKS_AGGREGATOR,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FORM).' '.$model->getTypeTitle(Block::TYPE_FORM), 'url' => ['/'.self::SECOND_MENU_BLOCKS_FORMS,], 'active' => $activeSecondMenu === self::SECOND_MENU_BLOCKS_FORMS,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MACRO).' Макросы', 'url' => ['/'.self::SECOND_MENU_SETTINGS_MACRO,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_MACRO,],
                    ];
                    break;
                case self::FIRST_MENU_ADMIN:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_MODERATOR).' Менеджеры', 'url' => ['/'.self::SECOND_MENU_ADMIN_MANAGERS,], 'active' => $activeSecondMenu === self::SECOND_MENU_ADMIN_MANAGERS,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_QUESTIONS).' Вопросы', 'url' => ['/'.self::SECOND_MENU_SENDED_QUESTION,], 'active' => $activeSecondMenu === self::SECOND_MENU_SENDED_QUESTION,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FORM).' Формы', 'url' => ['/'.self::SECOND_MENU_SENDED_FORM,], 'active' => $activeSecondMenu === self::SECOND_MENU_SENDED_FORM,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_TRASH).' Корзина', 'url' => ['/'.self::SECOND_MENU_ADMIN_TRASH,], 'active' => $activeSecondMenu === self::SECOND_MENU_ADMIN_TRASH,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_ORDERS).' Заказы', 'url' => ['/'.self::SECOND_MENU_ADMIN_ORDERS,], 'active' => $activeSecondMenu === self::SECOND_MENU_ADMIN_ORDERS,],
                    ];
                    break;
                case self::FIRST_MENU_REFERENCES:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PARTNER).' Партнеры', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PARTNER,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_PARTNER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_BUYER).' Покупатели', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_BUYER,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_BUYER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_DELIVERY).' Группы доставки', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_DELIVERY_GROUP,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_DELIVERY_GROUP,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_DELIVERY).' Доставка', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_DELIVERY,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_DELIVERY,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PAYMENT).' Группы оплаты', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PAYMENT_GROUP,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_PAYMENT_GROUP,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PAYMENT).' Оплата', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PAYMENT,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_PAYMENT,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE).' Обычные списки', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_REFERENCE,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_REFERENCE,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PROVERKACHEKA).' Проверка чека', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PROVERKACHEKA,], 'active' => $activeSecondMenu === self::SECOND_MENU_REFERENCES_PROVERKACHEKA,],
                    ];
                    break;
                case self::FIRST_MENU_SETTINGS:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_NEWS).' Агрегатор новостей', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_NEWS,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_NEWS,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_CHECKOUT).' Оформление заказа', 'url' => ['/'.self::SECOND_MENU_SETTINGS_CHECKOUT,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_CHECKOUT,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MAIN_SHOP_LEVEL).' Главный уровень магазинов', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_ICON_MAIN_SHOP_LEVEL,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_ICON_MAIN_SHOP_LEVEL,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MIGRATION).' Миграция БД', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_MIGRATION,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_MIGRATION,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_LK).' Личный кабинет', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_LK,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_LK,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_MAILING).' Почтовые рассылки', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_MAILING,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_MAILING,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FOOTER).' Футер', 'url' => ['/'.self::SECOND_MENU_SETTINGS_FOOTER,], 'active' => $activeSecondMenu === self::SECOND_MENU_SETTINGS_FOOTER,],
                    ];
                    break;
                case self::FIRST_MENU_PARSING:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SYSTEM_PARSING).' LrParts.ru', 'url' => ['/'.self::FIRST_MENU_PARSING.'/'.self::SECOND_MENU_PARSING_LRPARTS,], 'active' => $activeSecondMenu === self::SECOND_MENU_PARSING_LRPARTS,],
                    ];
                    break;
            }

            if ($items) {
                $menu = Nav::widget([
                    'id' => 'second-left-menu-widget',
                    'options' => ['class' => '',],
                    'items' => $items,
                    'encodeLabels' => false,
                ]);
            }
        }

        return $menu;
    }

    /**
     * @param string $activeSecondMenu
     * @param string $activeThirdMenu
     *
     * @return string
     * @throws \Exception
     */
    public static function thirdMenuLevel(string $activeSecondMenu, string $activeThirdMenu) : string
    {
        $menu = '';
        if (!Yii::$app->user->isGuest) {
            $items = [];
            switch ($activeSecondMenu) {
                case self::SECOND_MENU_BLOCKS_COMMON:
                    $model = new Block();
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_GALLERY).' '.$model->getTypeTitle(Block::TYPE_GALLERY), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_COMMON.'/'.self::THIRD_MENU_BLOCKS_GALLERY,], 'active' => $activeThirdMenu === self::THIRD_MENU_BLOCKS_GALLERY,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_TEXT).' '.$model->getTypeTitle(Block::TYPE_TEXT), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_COMMON.'/'.self::THIRD_MENU_BLOCKS_TEXT,], 'active' => $activeThirdMenu === self::THIRD_MENU_BLOCKS_TEXT,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_BANNER).' '.$model->getTypeTitle(Block::TYPE_BANNER), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_COMMON.'/'.self::THIRD_MENU_BLOCKS_BANNER,], 'active' => $activeThirdMenu === self::THIRD_MENU_BLOCKS_BANNER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SLIDER).' '.$model->getTypeTitle(Block::TYPE_SLIDER), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_COMMON.'/'.self::THIRD_MENU_BLOCKS_SLIDER,], 'active' => $activeThirdMenu === self::THIRD_MENU_BLOCKS_SLIDER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FILTER).' '.$model->getTypeTitle(Block::TYPE_FILTER), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_COMMON.'/'.self::THIRD_MENU_BLOCKS_FILTER,], 'active' => $activeThirdMenu === self::THIRD_MENU_BLOCKS_FILTER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTING).' '.$model->getTypeTitle(Block::TYPE_SETTING), 'url' => ['/'.self::FIRST_MENU_BLOCKS.'/'.self::SECOND_MENU_BLOCKS_COMMON.'/'.self::THIRD_MENU_BLOCKS_SETTING,], 'active' => $activeThirdMenu === self::THIRD_MENU_BLOCKS_SETTING,],
                    ];
                    break;
                case self::FIRST_MENU_STRUCTURES:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_DEPARTMENT).' Департаменты', 'url' => ['/'.self::FIRST_MENU_STRUCTURES.'/'.self::SECOND_MENU_STRUCTURES_DEPARTMENT,], 'active' => $activeThirdMenu === self::SECOND_MENU_STRUCTURES_DEPARTMENT,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_MENU).' Меню', 'url' => ['/'.self::FIRST_MENU_STRUCTURES.'/'.self::SECOND_MENU_STRUCTURES_MENU,], 'active' => $activeThirdMenu === self::SECOND_MENU_STRUCTURES_MENU,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_TAGS).' Теги', 'url' => ['/'.self::FIRST_MENU_STRUCTURES.'/'.self::SECOND_MENU_STRUCTURES_TAG,], 'active' => $activeThirdMenu === self::SECOND_MENU_STRUCTURES_TAG,],
                    ];
                    break;
                case self::FIRST_MENU_REFERENCES:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PARTNER).' Партнеры', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PARTNER,], 'active' => $activeThirdMenu === self::SECOND_MENU_REFERENCES_PARTNER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_BUYER).' Покупатели', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_BUYER,], 'active' => $activeThirdMenu === self::SECOND_MENU_REFERENCES_BUYER,],
                        ['label' => '[ '.IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_DELIVERY).' ] Группы доставки', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_DELIVERY_GROUP,], 'active' => $activeThirdMenu === self::SECOND_MENU_REFERENCES_DELIVERY_GROUP,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_DELIVERY).' Доставка', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_DELIVERY,], 'active' => $activeThirdMenu === self::SECOND_MENU_REFERENCES_DELIVERY,],
                        ['label' => '[ '.IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PAYMENT).' ] Группы оплаты', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PAYMENT_GROUP,], 'active' => $activeThirdMenu === self::SECOND_MENU_REFERENCES_PAYMENT_GROUP,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE_PAYMENT).' Оплата', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_PAYMENT,], 'active' => $activeThirdMenu === self::SECOND_MENU_REFERENCES_PAYMENT,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_REFERENCE).' Обычные списки', 'url' => ['/'.self::FIRST_MENU_REFERENCES.'/'.self::SECOND_MENU_REFERENCES_REFERENCE,], 'active' => $activeThirdMenu === self::SECOND_MENU_REFERENCES_REFERENCE,],
                    ];
                    break;
                case self::FIRST_MENU_SETTINGS:
                    $items = [
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_HEADER).' Header', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_HEADER,], 'active' => $activeThirdMenu === self::SECOND_MENU_SETTINGS_HEADER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_FOOTER).' Footer', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_FOOTER,], 'active' => $activeThirdMenu === self::SECOND_MENU_SETTINGS_FOOTER,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_NEWS).' Агрегатор новостей', 'url' => ['/'.self::FIRST_MENU_SETTINGS.'/'.self::SECOND_MENU_SETTINGS_NEWS,], 'active' => $activeThirdMenu === self::SECOND_MENU_SETTINGS_NEWS,],
                        ['label' => IconHelper::getSpanIcon(IconHelper::ICON_SETTINGS_CHECKOUT).' Оформление заказа', 'url' => ['/'.self::SECOND_MENU_SETTINGS_CHECKOUT,], 'active' => $activeThirdMenu === self::SECOND_MENU_SETTINGS_CHECKOUT,],
                    ];
                    break;
            }

            if ($items) {
                $menu = Nav::widget([
                    'id' => 'third-left-menu-widget',
                    'options' => ['class' => 'nav navbar-nav'],
                    'items' => $items,
                    'encodeLabels' => false,
                ]);
            }
        }

        return $menu;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function rightMenu() : string
    {
        $options = ['class' => ''];

        if (!Yii::$app->user->isGuest) {
            return Nav::widget([
                'options' => $options,
                'items' => [
                    '<li>' . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton('<i class="fas fa-sign-out-alt"></i> Выйти (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout'])
                        . Html::endForm()
                        . '</li>'
                ],
            ]);
        }

        return Nav::widget([
            'id' => '',
            'options' => $options,
            'items' => [
                ['label' => 'Войти', 'url' => ['/user/security/login'], 'options' => ['style' => 'font-weight:bold']],
            ],
        ]);
    }
}
