<?php
namespace common\components\helpers;

use backend\components\helpers\IconHelper;
use common\models\Block;
use common\models\BlockField;
use common\models\Content;
use common\models\ContentBlock;
use common\models\ContentBlockField;
use common\models\Settings;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;

class AppHelper
{
    const BTN_SAVE_CLOSE = 'save_close';
    const BTN_SAVE_STAY = 'save_stay';
    const BTN_CANCEL = 'cancel';

    const WP_URL = 'http://wptest.lr.ru';

    const WP_HEADER_PAGE_ID = 108;
    const WP_FOOTER_PAGE_ID = 104;
    const WP_MENU_PAGE_ID = 292;

    const HEADER_KEY = 'header';
    const FOOTER_KEY = 'footer';
    const MENU_KEY = 'menu';
    const MENU_TYPE_WP = 'wp';
    const MENU_TYPE_YII = 'yii';


    const WP_MAIN_LAYOUT_CACHE_KEY = 'wp_header_footer';
    const WP_MAIN_LAYOUT_CACHE_DURATION = 3600 * 3;

    const WP_ARTICLES_CACHE_KEY = 'wp_articles';
    const WP_ARTICLES_CACHE_DURATION = 3600 * 1;

    const WP_ARTICLE_CACHE_KEY = 'wp_article_';
    const WP_ARTICLE_CACHE_DURATION = 3600 * 24;

    const WP_LINK_CACHE_KEY = 'wp_link_';
    const WP_LINK_CACHE_DURATION = 3600 * 24;

    const WP_NEWS_CACHE_KEY = 'wp_news';
    const WP_NEWS_CACHE_DURATION = 3600 * 1;

    const WP_PAGES_CACHE_KEY = 'wp_pages';
    const WP_PAGES_CACHE_DURATION = 3600 * 1;

    const WP_PAGE_CACHE_KEY = 'wp_page';
    const WP_PAGE_CACHE_DURATION = 3600 * 1;

    const WP_MEDIA_CACHE_KEY = 'wp_media';
    const WP_MEDIA_CACHE_DURATION = 3600 * 1;

    const WP_NEW_CACHE_KEY = 'wp_new_';
    const WP_NEW_CACHE_DURATION = 3600 * 24;

    const HEADER_SETTINGS = 'header_settings';
    const HEADER_SETTINGS_DURATION = 3600 * 24 * 7;

    const GREEN_MENU_ACTIVE = 'green_menu_active';
    const GREEN_MENU_DEPARTMENTS = 'departments';
    const GREEN_MENU_MODELS = 'models';

    const TEMPLATE_KEY_SHOP = 'shop';
    const TEMPLATE_KEY_CAR_MODEL = 'model';
    const TEMPLATE_KEY_SHOP_MENU = 'shop_menu';
    const TEMPLATE_KEY_SHOP_MENU_TAG = 'shop_menu_tag';

    public static function someFunction() : string
    {
        return '';
    }

    /**
     * @param ActiveQuery $query
     *
     * @return string
     */
    public static function getRawSQL($query) : string
    {
        return $query->createCommand()->getRawSql();
    }

    /**
     * @param string $url
     *
     * @return bool|string
     * @throws \Exception
     */
    public static function curlRequest(string $url)
    {
        $ch = curl_init();

        if (!$ch) {
            throw new \Exception('Failed to initialize');
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        return \yii\helpers\Json::decode($response);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function getMainLayoutData() : array
    {
//        \Yii::$app->cache->flush();

        return \Yii::$app->cache->getOrSet(self::WP_MAIN_LAYOUT_CACHE_KEY, function () {
            $header = [];//self::curlRequest(self::WP_URL.'/wp-json/acf/v3/posts/'.self::WP_HEADER_PAGE_ID);
            $footer = [];//self::curlRequest(self::WP_URL.'/wp-json/acf/v3/posts/'.self::WP_FOOTER_PAGE_ID);
            $list = self::curlRequest(self::WP_URL.'/wp-json/acf/v3/posts/'.self::WP_MENU_PAGE_ID);
            $list = !empty($list['acf']['magaz']) ? $list['acf']['magaz'] : [];

            $menu = [];
            foreach ($list as $i => $item) {
                if (!empty($item['active'])) {
                    $menu[$item['alias']] = $item;

                    if (!empty($menu[$item['alias']]['menu']) && is_array($menu[$item['alias']]['menu'])) {
                        $subMenu = [];
                        foreach ($menu[$item['alias']]['menu'] as $subItem) {
                            if (!empty($subItem['active'])) {
                                $subMenu[$subItem['alias']] = $subItem;
                            }
                        }

                        $menu[$item['alias']]['menu'] = $subMenu;
                    }
                }
            }

            return [
                self::HEADER_KEY => !empty($header['acf']) ? $header['acf'] : [],
                self::FOOTER_KEY => !empty($footer['acf']) ? $footer['acf'] : [],
                self::MENU_KEY => $menu,
            ];
        }, self::WP_MAIN_LAYOUT_CACHE_DURATION);
    }

    /**
     * @param $value
     * @param $defaultValue
     *
     * @return mixed
     */
    public static function getValue($value, $defaultValue)
    {
        return !empty($value) ? $value : $defaultValue;
    }

    /**
     * @param string $link
     *
     * @return array
     */
    public static function getWpLinkData(string $link) : array
    {
        $key = self::WP_LINK_CACHE_KEY.'_'.$link;

        return \Yii::$app->cache->getOrSet($key, function () use ($link) {
            return self::curlRequest($link);
        }, self::WP_LINK_CACHE_DURATION);
    }

    /**
     * @return array
     */
    public static function getWpArticles() : array
    {
        return [];

        return \Yii::$app->cache->getOrSet(self::WP_ARTICLES_CACHE_KEY, function () {
            return self::curlRequest(self::WP_URL.'/wp-json/acf/v3/posts/'.self::WP_HEADER_PAGE_ID);
        }, self::WP_ARTICLES_CACHE_DURATION);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getWpArticle(int $id) : array
    {
        return [];

        $key = self::WP_ARTICLE_CACHE_KEY.'_'.$id;

        return \Yii::$app->cache->getOrSet($key, function () use ($id) {
            return self::curlRequest(self::WP_URL.'/wp-json/acf/v3/posts/'.$id);
        }, self::WP_ARTICLE_CACHE_DURATION);
    }

    /**
     * @return array
     */
    public static function getWpNews() : array
    {
        return [];

        return \Yii::$app->cache->getOrSet(self::WP_NEWS_CACHE_KEY, function () {
            return self::curlRequest(self::WP_URL.'/wp-json/acf/v3/posts/'.self::WP_HEADER_PAGE_ID);
        }, self::WP_NEWS_CACHE_DURATION);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getWpNew(int $id) : array
    {
        return [];

        $key = self::WP_NEW_CACHE_KEY.'_'.$id;

        return \Yii::$app->cache->getOrSet($key, function () use ($id) {
            return self::curlRequest(self::WP_URL.'/wp-json/acf/v3/posts/'.$id);
        }, self::WP_NEW_CACHE_DURATION);
    }

    /**
     * @param array $params
     *
     * @return array
     * @throws \Exception
     */
    public static function getWpSearchResult(array $params) : array
    {
        return [];

        return self::curlRequest(self::WP_URL.'/wp-json/acf/v3/posts/'.$params);
    }

    /**
     * @return array
     */
    public static function getWpPages() : array
    {
        return \Yii::$app->cache->getOrSet(self::WP_PAGES_CACHE_KEY, function () {
            return self::curlRequest(self::WP_URL.'/wp-json/wp/v2/pages');
        }, self::WP_PAGES_CACHE_DURATION);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getWpPage(int $id) : array
    {
        $key = self::WP_PAGE_CACHE_KEY.'_'.$id;

        return \Yii::$app->cache->getOrSet($key, function () use ($id) {
            return self::curlRequest(self::WP_URL.'/wp-json/wp/v2/pages/'.$id);
        }, self::WP_PAGE_CACHE_DURATION);
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public static function getWpMedia(int $id) : array
    {
        $key = self::WP_MEDIA_CACHE_KEY.'_'.$id;

        return \Yii::$app->cache->getOrSet($key, function () use ($id) {
            return self::curlRequest(self::WP_URL.'/wp-json/wp/v2/media/'.$id);
        }, self::WP_MEDIA_CACHE_DURATION);
    }

    /**
     * @param      $color
     * @param bool $opacity
     *
    $color = '#ffa226';
    $rgb = hex2rgba($color);
    $rgba = hex2rgba($color, 0.7);
     *
     * @return string
     */
    public static function hex2rgba($color, $opacity = false)
    {
        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color)) {
            return $default;
        }

        //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) === 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) === 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
    }

    /**
     * Truncates a string to the number of words specified.
     *
     * @param string $string The string to truncate.
     * @param int $count How many words from original string to include into truncated string.
     * @param string $suffix String to append to the end of truncated string.
     * @param bool $asHtml Whether to treat the string being truncated as HTML and preserve proper HTML tags.
     * This parameter is available since version 2.0.1.
     * @return string the truncated string.
     */
    public static function truncateWords($string, $count, $suffix = '...', $asHtml = false)
    {
        if ($asHtml) {
            return static::truncateHtml($string, $count, $suffix);
        }

        $words = preg_split('/(\s+)/u', trim($string), null, PREG_SPLIT_DELIM_CAPTURE);
        if (count($words) / 2 > $count) {
            return implode('', array_slice($words, 0, ($count * 2) - 1)) . $suffix;
        }

        return $string;
    }

    /**
     * Truncate a string while preserving the HTML.
     *
     * @param string $string The string to truncate
     * @param int $count
     * @param string $suffix String to append to the end of the truncated string.
     * @param string|bool $encoding
     * @return string
     * @since 2.0.1
     */
    protected static function truncateHtml($string, $count, $suffix, $encoding = false)
    {
        $config = \HTMLPurifier_Config::create(null);
        if (Yii::$app !== null) {
            $config->set('Cache.SerializerPath', Yii::$app->getRuntimePath());
        }
        $lexer = \HTMLPurifier_Lexer::create($config);
        $tokens = $lexer->tokenizeHTML($string, $config, new \HTMLPurifier_Context());
        $openTokens = [];
        $totalCount = 0;
        $depth = 0;
        $truncated = [];
        foreach ($tokens as $token) {
            if ($token instanceof \HTMLPurifier_Token_Start) { //Tag begins
                $openTokens[$depth] = $token->name;
                $truncated[] = $token;
                ++$depth;
            } elseif ($token instanceof \HTMLPurifier_Token_Text && $totalCount <= $count) { //Text
                if (false === $encoding) {
                    preg_match('/^(\s*)/um', $token->data, $prefixSpace) ?: $prefixSpace = ['', ''];
                    $token->data = $prefixSpace[1] . self::truncateWords(ltrim($token->data), $count - $totalCount, '');
                    $currentCount = self::countWords($token->data);
                } else {
                    $token->data = self::truncate($token->data, $count - $totalCount, '', $encoding);
                    $currentCount = mb_strlen($token->data, $encoding);
                }
                $totalCount += $currentCount;
                $truncated[] = $token;
            } elseif ($token instanceof \HTMLPurifier_Token_End) { //Tag ends
                if ($token->name === $openTokens[$depth - 1]) {
                    --$depth;
                    unset($openTokens[$depth]);
                    $truncated[] = $token;
                }
            } elseif ($token instanceof \HTMLPurifier_Token_Empty) { //Self contained tags, i.e. <img/> etc.
                $truncated[] = $token;
            }
            if ($totalCount >= $count) {
                if (0 < count($openTokens)) {
                    krsort($openTokens);
                    foreach ($openTokens as $name) {
                        $truncated[] = new \HTMLPurifier_Token_End($name);
                    }
                }
                break;
            }
        }
        $context = new \HTMLPurifier_Context();
        $generator = new \HTMLPurifier_Generator($config, $context);

        return $generator->generateFromTokens($truncated) . ($totalCount >= $count ? $suffix : '');
    }

    /**
     * Truncates a string to the number of characters specified.
     *
     * @param string $string The string to truncate.
     * @param int $length How many characters from original string to include into truncated string.
     * @param string $suffix String to append to the end of truncated string.
     * @param string $encoding The charset to use, defaults to charset currently used by application.
     * @param bool $asHtml Whether to treat the string being truncated as HTML and preserve proper HTML tags.
     * This parameter is available since version 2.0.1.
     * @return string the truncated string.
     */
    public static function truncate($string, $length, $suffix = '...', $encoding = null, $asHtml = false)
    {
        if ($encoding === null) {
            $encoding = Yii::$app ? Yii::$app->charset : 'UTF-8';
        }
        if ($asHtml) {
            return static::truncateHtml($string, $length, $suffix, $encoding);
        }

        if (mb_strlen($string, $encoding) > $length) {
            return rtrim(mb_substr($string, 0, $length, $encoding)) . $suffix;
        }

        return $string;
    }

    /**
     * Counts words in a string.
     * @since 2.0.8
     *
     * @param string $string
     * @return int
     */
    public static function countWords($string)
    {
        return count(preg_split('/\s+/u', $string, null, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * @return Settings
     */
    public static function getNewsSettings() : Settings
    {
        $model = Settings::findOne(['type' => Settings::TYPE_NEWS,]);

        if (!$model) {
            $model = new Settings();
            $model->type = Settings::TYPE_NEWS;
            $model->news_title = '';
            $model->news_count = Settings::NEWS_COUNT_DEFAULT;
            $model->news_is_expand = true;
        } else {
            $data = $model->getData();
            $model->news_title = $data['news_title'] ?? '';
            $model->news_count = $data['news_count'] ?? Settings::NEWS_COUNT_DEFAULT;
            $model->news_is_expand = $data['news_is_expand'] ?? true;
        }

        return $model;
    }

    /**
     * @return Settings
     */
    public static function getCartSettings() : Settings
    {
        $model = Settings::findOne(['type' => Settings::TYPE_CART,]);

        if (!$model) {
            $model = new Settings();
            $model->type = Settings::TYPE_CART;
            $model->setData([Settings::CART_SUCCESS_MESSAGE_KEY => Settings::CART_SUCCESS_DEFAULT, Settings::CART_FAILURE_MESSAGE_KEY => Settings::CART_FAILURE_DEFAULT,]);
        }

        return $model;
    }

    /**
     * @return string
     */
    public static function getSubmitButtons() : string
    {
        return Html::submitButton( IconHelper::getSpanIcon(IconHelper::ICON_SAVE_AND_EDIT).' Сохранить и продолжить', ['class' => 'btn btn-primary', 'name' => self::BTN_SAVE_STAY,])
            .' '.Html::submitButton(IconHelper::getSpanIcon(IconHelper::ICON_SAVE).' Сохранить', ['class' => 'btn btn-success', 'name' => self::BTN_SAVE_CLOSE,]);
    }

    /**
     * @param      $view
     * @param      $to
     * @param      $subject
     * @param      $params
     * @param bool $isOnlyHtml
     *
     * @return bool
     */
    public static function sendMessage($view, $to, $subject, $params, $isOnlyHtml = false) : bool
    {
        /** @var \yii\mail\BaseMailer $mailer */
        $mailer = \Yii::$app->mailer;
        $mailer->viewPath = '@app/views/mail';
        $mailer->getView()->theme = \Yii::$app->view->theme;

        $sender = isset(\Yii::$app->params['adminEmail']) ? \Yii::$app->params['adminEmail'] : 'no-reply@lr.ru';

        $views = ['html' => $view,];
        if (!$isOnlyHtml) {
            $views['text'] = 'text/'.$view;
        }

        return $mailer->compose($views, $params)
            ->setTo($to)
            ->setFrom($sender)
            ->setSubject($subject)
            ->send();
    }

    /**
     * @return array
     */
    public static function getHeaderSettings() : array
    {
        $key = self::HEADER_SETTINGS;

        return \Yii::$app->cache->getOrSet($key, function () {
            $settings = ['image' => '/img/header-logo.svg', 'phone' => '+7 (495) 649 60 60', 'phone2' => '+7 (495) 649 60 60', 'slogan' => 'Автомобильные товары с доcтавкой по РФ',];
            $content = Content::findOne(['id' => Content::SETTING_HEADER_ID, 'type' => Content::TYPE_SETTING, 'deleted_at' => null,]);

            if ($content) {
                $blockQuery = Block::find()
                    ->select([
                        Block::tableName().'.id',
                        Block::tableName().'.name',
                        Block::tableName().'.description',
                        Block::tableName().'.type',
                        Block::tableName().'.global_type',
                        ContentBlockField::tableName().'.data',
                        ContentBlock::tableName().'.id AS content_block_id',
                        ContentBlock::tableName().'.type AS content_block_type',
                        ContentBlock::tableName().'.sort AS content_block_sort',
                        ContentBlock::tableName().'.is_active AS content_block_is_active',
                    ])
                    ->innerJoin(ContentBlock::tableName(), ContentBlock::tableName().'.block_id = '.Block::tableName().'.id')
                    ->leftJoin(ContentBlockField::tableName(), ContentBlock::tableName().'.id = '.ContentBlockField::tableName().'.content_block_id')
                    ->where([
                        ContentBlock::tableName().'.type' => ContentBlock::TYPE_BLOCK,
                        ContentBlock::tableName().'.content_id' => $content->id,
                        Block::tableName().'.deleted_at' => null,
                    ])
                    ->asArray()
                    ->indexBy('content_block_id');

                $rows = $blockQuery->all();
                $block = array_shift($rows);

                $fields = ContentHelper::getBlockFields($block['id'], $block['content_block_type']);
                $json = Json::decode($block['data']);

                $headerImage = $headerPhone = $headerSlogan = '';
                foreach ($fields as $field) {
                    $value = $json[$field['id']] ?? '';

                    switch ($field['type']) {
                        case BlockField::TYPE_IMAGE:
                            $headerImage = (string)$value;
                            break;
                        case BlockField::TYPE_TEXT:
                            if ($field['name'] === 'Слоган') {
                                $headerSlogan = (string)$value;
                            } elseif ($field['name'] === 'Телефон') {
                                $headerPhone = (string)$value;
                            }
                            break;
                    }
                }

                if (!empty($headerImage)) {
                    $settings['image'] = $headerImage;
                }
                if (!empty($headerPhone)) {
                    $settings['phone'] = $headerPhone;
                }
                if (!empty($headerSlogan)) {
                    $settings['slogan'] = $headerSlogan;
                }
            }

            return $settings;
        }, self::HEADER_SETTINGS_DURATION);
    }

    /**
     * @return Content|null
     */
    public static function getFooterSettings() : ?Content
    {
        return Content::findOne(['id' => Content::SETTING_FOOTER_ID, 'type' => Content::TYPE_SETTING, 'deleted_at' => null,]);
    }

    /**
     * @param string $key
     * @param        $value
     */
    public static function setSessionValue(string $key, $value) : void
    {
        Yii::$app->session->set($key, $value);
    }

    /**
     * @param string $key
     * @param        $value
     * @param null   $expire
     */
    public static function setCookieValue(string $key, $value, $expire = null) : void
    {
        $cookies = Yii::$app->response->cookies;

        if (empty($expire)) {
            $expire = time() + 86400 * 7; //неделя
        }

        $cookies->add(new \yii\web\Cookie([
            'name' => $key,
            'value' => $value,
            'expire' => $expire,
        ]));
    }

    /**
     * @param string $key
     */
    public static function deleteCookie(string $key) : void
    {
        $cookies = Yii::$app->response->cookies;

        $cookies->remove($key);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public static function getSessionValue(string $key)
    {
        return Yii::$app->session->get($key);
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public static function getCookieValue(string $key, $default = null)
    {
        $cookies = Yii::$app->request->cookies;

        return $cookies->getValue($key, $default);
    }
}