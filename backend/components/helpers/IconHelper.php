<?php
namespace backend\components\helpers;

use yii\helpers\Html;

class IconHelper
{
    const ICON_HOME_PAGE = 'fa fa-home';
    const ICON_PAGES = 'fa fa-book';
    const ICON_NEWS = 'fa fa-globe';
    const ICON_BLOCKS = 'fas fa-th';
    const ICON_STRUCTURES = 'fa fa-sitemap';
    const ICON_ANALIZE = 'fas fa-lightbulb';
    const ICON_GALLERY = 'far fa-images';
    const ICON_TEXT = 'far fa-file-alt';
    const ICON_BANNER = 'fa fa-th-large';
    const ICON_SLIDER = 'fas fa-sliders-h';
    const ICON_FILTER = 'far fa-window-maximize';
    const ICON_AGGREGATOR = 'fas fa-tape';
    const ICON_SETTING = 'fas fa-toolbox';
    const ICON_DEPARTMENT = 'fa fa-map-marker';
    const ICON_MANUFACTURERS = 'fas fa-truck-monster';
    const ICON_DEPARTMENT_TREE = 'fas fa-tree';
    const ICON_DEFAULT = 'fas fa-question';
    const ICON_MENU = 'fa fa-list-ul';
    const ICON_MODEL = 'fa fa-truck';
    const ICON_HEADER = 'far fa-hand-point-up';
    const ICON_FOOTER = 'far fa-hand-point-down';
    const ICON_QUESTION = 'fas fa-question';
    const ICON_SETTINGS_NEWS = 'fas fa-grip-horizontal';
    const ICON_SETTINGS_MACRO = 'fas fa-star-of-life';
    const ICON_SETTINGS_CHECKOUT = 'fa fa-gift';
    const ICON_SETTINGS_MAIN_SHOP_LEVEL = 'fas fa-shapes';
    const ICON_SETTINGS_MIGRATION = 'fas fa-database';
    const ICON_SETTINGS_LK = 'far fa-address-card';
    const ICON_SETTINGS_MAILING = 'far fa-envelope';
    const ICON_LINKTAG_DEPARTMENT = 'fas fa-link';
    const ICON_SETTINGS_GREEN_MENU = 'fas fa-bars';
    const ICON_READY = 'far fa-clone';
    const ICON_FORM = 'fas fa-mail-bulk';
    const ICON_SAVE_AND_EDIT = 'fas fa-edit';
    const ICON_SAVE_AND_CLOSE = 'far fa-edit';
    const ICON_REFERENCE = 'fas fa-layer-group';
    const ICON_REFERENCE_BUYER = 'fas fa-shopping-basket';
    const ICON_REFERENCE_DELIVERY = 'fas fa-truck';
    const ICON_REFERENCE_PAYMENT = 'fas fa-dollar-sign';
    const ICON_REFERENCE_PARTNER = 'fas fa-handshake';
    const ICON_REFERENCE_PROVERKACHEKA = 'fas fa-qrcode';
    const ICON_TRASH = 'far fa-trash-alt';
    const ICON_SPECIAL_GROUP = 'fas fa-layer-group';
    const ICON_SPECIAL_FLAG = 'fas fa-flag';
    const ICON_LINK = 'fas fa-link';

    const ICON_REVIEWS = 'fa fa-bullhorn';
    const ICON_REVIEW_COMMENTS = 'fa fa-comment';
    const ICON_ARTICLE_COMMENTS = 'fa fa-comment-o';
    const ICON_COMMENTS = 'fa fa-comments-o';
    const ICON_OBJECTS = 'glyphicon glyphicon-link';
    const ICON_ARTICLES = 'fa fa-list';
    const ICON_USERS = 'fa fa-users';
    const ICON_MODERATOR = 'fa fa-user-secret';
    const ICON_TAGS = 'fa fa-tags';
    const ICON_COUNTRY_PHONE = 'fa fa-phone';
    const ICON_TAG = 'fa fa-tag';
    const ICON_DIRECTORIES = 'fa fa-archive';
    const ICON_ADD = 'fa fa-plus';
    const ICON_SAVE = 'fa fa-check';
    const ICON_CATEGORIES = 'fa fa-sitemap';
    const ICON_LANGUAGES = 'fa fa-language';
    const ICON_BLOCKINGS = 'fa fa-ban';
    const ICON_BLOCKING_REASONS = 'fa fa-eye-slash';
    const ICON_UNBLOCKING_REASONS = 'fa fa-eye';
    const ICON_BLOCKING_OBJECT = 'fa fa-cog';
    const ICON_SITE_PAGES = 'fa fa-gears';
    const ICON_HELP_CATEGORIES = 'fa fa-sitemap';
    const ICON_SECTIONS = 'fa fa-address-card-o';
    const ICON_STATIC_PAGE = 'fa fa-book';
    const ICON_HELPS = 'fa fa-question-circle';
    const ICON_QUESTIONS = 'fas fa-question';
    const ICON_ANSWERS = 'fa fa-question';
    const ICON_IMAGES = 'far fa-image';
    const ICON_NO_IMAGES = 'far fa-frown';
    const ICON_RATING_CONSTANTS = 'fa fa-signal';
    const ICON_SYSTEM_SETTINGS = 'fas fa-tools';
    const ICON_SYSTEM_PARSING = 'fas fa-globe';
    const ICON_SYSTEM_ADMIN = 'fa fa-user';
    const ICON_SYSTEM_SENDED = 'fas fa-share-square';
    const ICON_ORDERS = 'fas fa-shopping-basket';
    const ICON_RATING_CONSTANTS_HISTORY = 'fa fa-history';
    const ICON_REVIEW_DRAFT_EDIT = 'fa fa-pencil-square';
    const ICON_REVIEW_DRAFT_SIMPLE = 'fa fa-pencil';
    const ICON_PARSING = 'fa fa-globe';
    const ICON_CART = 'fa fa-shopping-cart';
    const ICON_REJECT = 'fa fa-thumbs-down';
    const ICON_ACTIVATE = 'fa fa-thumbs-up';
    const ICON_DELETE = 'fa fa-trash-o';
    const ICON_ARCHIVE = 'fa fa-archive';
    const ICON_CHECK = 'fa fa-check';
    const ICON_EDIT = 'fa fa-edit';
    const ICON_TASK_START = 'fa fa-check-circle-o';
    const ICON_TASK_CONTINUE = 'fa fa-check-square';
    const ICON_PURGE = 'fa fa-close';
    const ICON_ACTIVITY = 'fa fa-tasks';
    const ICON_INFO = 'fa fa-info-circle';
    const ICON_NOTIFICATIONS = 'fa fa-envelope';
    const ICON_BELL = 'fa fa-bell-o';
    const ICON_CLOCK = 'fa fa-clock-o';
    const ICON_TASK = 'fa fa-flash';
    const ICON_EVENT = 'fa fa-bell-o';
    const ICON_ANALYTICS = 'fa fa-bar-chart';
    const ICON_ANALYTICS_COMMON = 'fa fa-line-chart';
    const ICON_ANALYTICS_VIEWS = 'fa fa-eye';
    const ICON_ANALYTICS_LOGS = 'fa fa-code-fork';
    const ICON_FAVORITE = 'fa fa-star';
    const ICON_REFRESH = 'fa fa-refresh';
//    const ICON_ = '';

    /**
     * @param string $class
     * @param string $title
     *
     * @return string
     */
    public static function getIcon(string $class, string $title = '') : string
    {
        return  Html::tag('i', '', ['class' => $class, 'title' => $title,]);
    }

    /**
     * @param string $class
     * @param string $title
     *
     * @return string
     */
    public static function getSpanIcon(string $class, string $title = '') : string
    {
        return  Html::tag('span', '', ['class' => $class, 'title' => $title,]);
    }
}
