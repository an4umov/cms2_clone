<?php
namespace common\components\helpers;

use common\models\Articles;
use common\models\Catalog;
use common\models\CatalogLinktagDepartment;
use common\models\CatalogTreeSetting;
use common\models\Department;
use common\models\FullPrice;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\Delivery;
use common\models\SettingsMainShopLevel;
use common\models\SpecialOffers;
use frontend\components\widgets\CatalogListWidget;
use frontend\components\widgets\ProductOffersWidget;
use frontend\models\search\ArticleItemSearch;
use frontend\models\search\CatalogListSearch;
use frontend\models\search\CatalogTreeSearch;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class CatalogHelper
{
    const BREADCRUMB_TEMPLATE = "<li> / </li>\n <li>{link}</li>\n";
    const CONSOLE_SALT = 't3aJPZmfGPeUxrN73kVAE9M9';

    const COOKIE_GROUPS_LAST_URL = 'groups_last_url';
    const COOKIE_MODELS_LAST_URL = 'models_last_url';

    const COOKIE_GROUPS_DEPARTMENTS_VIEW = 'groups_departments_view';
    const COOKIE_MODELS_DEPARTMENTS_VIEW = 'models_departments_view';

    const COOKIE_LRPARTS_SEARCH = 'lrparts_search';

    const COOKIE_DEPARTMENTS_VIEW_LIMIT = 5;

    const EXTENSION_PNG = 'png';
    const EXTENSION_WEBP = 'webp';
    const EXTENSION_JPG = 'jpg';

    const CATALOG_CODE_START = 'KAT';
    const SORT_DEFAULT = 999999;

    const CACHE_CATALOG_LINKTAG_DEPARTMENT = 'catalog-linktag-department';

    const COUNTER_TYPE_TYPE = 'type';
    const COUNTER_TYPE_MODEL = 'model';
    const COUNTER_TYPE_GENERATION = 'generation';

    public static function generateVendorURLs($articleNumber): array
    {
        $request = \Yii::$app->request;
        $params = $request->getBodyParams();
        $query = $request->getQueryParam('text');

        if (!empty($params)) {
            $urlString = key($params);
            $urlString = str_replace(array('/dep'), "", $urlString);
            $urlArr = array_filter(explode('/', $urlString));
            $finalVendorUrl = ['shop/vendor', 'shop' => $urlArr[1], 'menu' => $urlArr[2], 'tag' => $urlArr[3], 'number' => $articleNumber,];

        } else {
            if (!empty($query)) {
                $finalVendorUrl = ['shop/vendor', 'number' => $articleNumber, 'query' => $query];
            } else {
                $finalVendorUrl = ['shop/vendor', 'number' => $articleNumber];
            }
        }
        
        return $finalVendorUrl;
    }

    public static function generateProductURLs($articleNumber, $productKey): array
    {
        $request = \Yii::$app->request;
        $params = $request->getBodyParams();
        $query = $request->getQueryParam('text');

        if (!empty($params)) {
            $urlString = key($params);
            $urlString = str_replace(array('/dep'), "", $urlString);
            $urlArr = array_filter(explode('/', $urlString));
            $finalProductUrl = ['shop/product', 'shop' => $urlArr[1], 'menu' => $urlArr[2], 'tag' => $urlArr[3], 'number' => $articleNumber, 'key' => $productKey];

        } else {
            if (!empty($query)) {
                $finalProductUrl = ['shop/product', 'number' => $articleNumber, 'key' => $productKey, 'query' => $query];
            } else {
                $finalProductUrl = ['shop/product', 'number' => $articleNumber, 'key' => $productKey];
            }
        }
        
        return $finalProductUrl;
    }

    /**
     * @param int $level
     *
     * @return string
     */
    public static function getCatalogLoader(int $level) : string
    {
        return Html::tag('div', Html::img('/img/loader.gif', ['style' => 'display: none; width: 22px; vertical-align: baseline;',]), ['id' => 'catalog-loader-'.$level, 'class' => 'catalog-loader', 'style' => 'display: inline-block; float: right;',]);
    }

    /**
     * @param Department $department
     * @param string     $departmentMenu
     * @param string     $departmentMenuTag
     * @param string     $catalogCode
     *
     * @return array
     */
    public static function getBaseCatalogRoute(Department $department, $departmentMenu = '', $departmentMenuTag = '', $catalogCode = '') : array
    {
        $route = ['shop/shop', 'shop' => $department->url,];

        if (!empty($departmentMenu)) {
            $route['menu'] = $departmentMenu;
        } elseif (!empty($catalogCode)) {
            $route['menu'] = $catalogCode;
        }

        if (!empty($departmentMenuTag)) {
            $route['tag'] = $departmentMenuTag;
        } elseif (!empty($catalogCode)) {
            $route['tag'] = $catalogCode;
        }

        return $route;
    }

    /**
     * @param string $var
     *
     * @return bool
     */
    public static function isCatalogCode(string $var) : bool
    {
        return substr($var, 0, 3) === self::CATALOG_CODE_START;
    }

    /**
     * @param array $row
     *
     * @return string
     */
    public static function generateFullPriceKey(array $row) : string
    {
        return substr(sha1($row['price_list_code'].'_'.$row['article_number'].'_'.$row['manufacturer'].'_'.$row['product_code'].'_'.$row['commentary'].'_'.microtime()), 0, FullPrice::KEY_LENGTH);
    }

    /**
     * @param array $row
     *
     * @return string
     */
    public static function generatePriceListKey(array $row) : string
    {
        return substr(sha1(implode('_', $row)), 0, PriceList::KEY_LENGTH);
    }

    /**
     * @param array  $menu
     * @param string $shop
     *
     * @return array
     */
    public static function getFirstPageGreenMenu(array $menu, string $shop) : array
    {
        $greenMenu = [];
        foreach ($menu as $item) {
            if ($item['alias'] === $shop) {
                $greenMenu = $item['menu'];

                break;
            }
        }

        ArrayHelper::multisort($greenMenu, ['order',], [SORT_ASC,]);

        return $greenMenu;
    }

    /**
     * @param $salt
     *
     * @return bool
     */
    public static function checkSalt($salt) : bool
    {
        return self::CONSOLE_SALT === $salt;
    }

    /**
     * @param string $key
     * @param array  $data
     *
     * @return bool
     */
    public static function updateFullPriceRow(string $key, array $data)
    {
        $model = FullPrice::find()->where([FullPrice::PRODUCT_KEY => $key,])->one();

        if ($model) {
            $isChanged = false;
            foreach ($data as $field => $value) {
                if (isset($model->$field)) {
                    $model->$field = $value;
                    $isChanged = true;
                }
            }

            if ($isChanged && $model->validate()) {
                return $model->save();
            }
        }

        return false;
    }

    /**
     * @param string $code
     *
     * @return Catalog
     * @throws NotFoundHttpException
     */
    public static function getCatalogModelByCode(string $code) : Catalog
    {
        if (($model = Catalog::findOne(['code' => $code,])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param string $code
     *
     * @return Catalog
     * @throws NotFoundHttpException
     */
    public static function getTopCatalogModelByCode(string $code) : Catalog
    {
        if (($model = Catalog::findOne(['code' => $code, 'level' => Catalog::LEVEL_2,])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param FullPrice $model
     *
     * @return string
     */
    public static function getFullPriceDelivery(FullPrice $model) : string
    {
        switch ($model->delivery_time) {
            case FullPrice::DELIVERY_TIME_ON_STOCK:
                $class = 'fas fa-layer-group';
                break;
            case FullPrice::DELIVERY_TIME_MOSCOW_3_DAYS:
                $class = 'fas fa-users-cog';
                break;
            case FullPrice::DELIVERY_TIME_EU_45_DAYS:
                $class = 'fas fa-users-cog';
                break;
            case FullPrice::DELIVERY_TIME_SPECIFIED:
                $class = 'fas fa-users-cog';
                break;
            default:
                $class = 'fas fa-bars';
                break;
        }

        return '<div class="stock"><i class="'.$class.'"></i> '.$model->delivery_time.'</div> '.$model->delivery;
    }

    /**
     * @param string $delivery
     *
     * @return bool
     */
    public static function isInStock(string $delivery) : bool
    {
        $delivery = mb_convert_case($delivery, MB_CASE_LOWER);

        return ($delivery === FullPrice::DELIVERY_IN_STOCK || $delivery === FullPrice::DELIVERY_PARTNER);
    }

    /**
     * @param Articles $article
     * @param array    $params
     *
     * @return bool
     */
    public static function isHasFullPriceInStock(Articles $article, array $params = []) : bool
    {
        $query = FullPrice::find()
            ->where([
                FullPrice::tableName() . '.article_number' => $article->number,
                FullPrice::tableName() . '.delivery' => [FullPrice::DELIVERY_PARTNER, FullPrice::DELIVERY_IN_STOCK,],
            ]);

        foreach ($params as $key => $value) {
            $query->andFilterWhere([$key => $value,]);
        }

        return $query->exists();
    }

    /**
     * @param string $number
     *
     * @return Articles|null
     */
    public static function getArticleModelByNumber(string $number)
    {
        return Articles::findOne(['number' => $number,]);
    }

    /**
     * @param string $id
     *
     * @return Articles|null
     */
    public static function getCatalogModelByProductKey(string $key)
    {
        return PriceList::findOne(['key' => $key,]);
    }

    /**
     * @param string $articleCode
     *
     * @return Catalog|null
     */
    public static function getCatalogModelByArticle(string $articleCode)
    {
        return Catalog::findOne(['article' => $articleCode,]);
    }

    /**
     * @param string $key
     *
     * @return FullPrice|null
     */
    public static function getFullPriceModelByKey(string $key)
    {
        return FullPrice::findOne([FullPrice::PRODUCT_KEY => $key,]);
    }

    /**
     * @param string $key
     *
     * @return PriceList|null
     */
    public static function getPriceListModelByKey(string $key)
    {
        return PriceList::find()->where([PriceList::PRODUCT_KEY => $key,])->with('article')->one();
    }

    /**
     * Get delivery
     * @param string $delivery_code
     *
     * @return PriceList|null
     */
    public static function getDeliveryTimeText(string $delivery_code)
    {
        return Delivery::findOne(['code' => $delivery_code,]);
    }

    /**
     * @param string $code
     *
     * @return string
     */
    public static function getCatalogTopLevelImageUrl(string $code) : string
    {
        $basePath = \Yii::getAlias('@frontendImages').DIRECTORY_SEPARATOR;
        $path = $basePath.Catalog::IMAGES_DIR1.DIRECTORY_SEPARATOR.$code;

        $pathes = [
            self::EXTENSION_JPG => $path.'.'.self::EXTENSION_JPG,
            self::EXTENSION_WEBP => $path.'.'.self::EXTENSION_WEBP,
            self::EXTENSION_PNG => $path.'.'.self::EXTENSION_PNG,
        ];
        foreach ($pathes as $ext => $path) {
            if (file_exists($path)) {
                return '/img/'.Catalog::IMAGES_DIR1.'/'.$code.'.'.$ext;
            }
        }

        return '/img/'.Catalog::IMAGE_NOT_AVAILABLE;
    }

    /**
     * @param string $articleNumber
     *
     * @return string
     * @throws \ImagickException
     */
    public static function getSpecialOfferImageUrl(string $articleNumber) : string
    {
        $basePath = \Yii::getAlias('@frontendImages').DIRECTORY_SEPARATOR;
        $path = $basePath.Catalog::IMAGES_SPECIAL_OFFER.DIRECTORY_SEPARATOR.$articleNumber;

        $pathes = [
            self::EXTENSION_JPG => $path.'.'.self::EXTENSION_JPG,
            self::EXTENSION_PNG => $path.'.'.self::EXTENSION_PNG,
            self::EXTENSION_WEBP => $path.'.'.self::EXTENSION_WEBP,
        ];
        foreach ($pathes as $ext => $filepath) {
            if (file_exists($filepath)) {
                return '/img/'.Catalog::IMAGES_SPECIAL_OFFER.'/'.$articleNumber.'.'.$ext;
            }
        }

        $path = $basePath.Catalog::IMAGES_DIR_LR.DIRECTORY_SEPARATOR.$articleNumber;
        $pathes = [
            self::EXTENSION_JPG => $path.'.'.self::EXTENSION_JPG,
            self::EXTENSION_PNG => $path.'.'.self::EXTENSION_PNG,
            self::EXTENSION_WEBP => $path.'.'.self::EXTENSION_WEBP,
        ];
        foreach ($pathes as $ext => $filepath) {
            if (file_exists($filepath)) {
                $imagick = new \Imagick($filepath);
                $imagick->setbackgroundcolor('rgb(255, 255, 255)');
                $imagick->thumbnailImage(180, 180, true, true);
                $imagick->setFormat($ext);
                $imagick->writeImage($path.'.'.$ext);
                $imagick->destroy();

                if (file_exists($path.'.'.$ext)) {
                    return '/img/'.Catalog::IMAGES_SPECIAL_OFFER.'/'.$articleNumber.'.'.$ext;
                }
            }
        }

        return '/img/'.Catalog::IMAGE_NOT_AVAILABLE_180;
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public static function getSpecialOfferHtml(array $model) : string
    {
        $html = '
        <div class="special-slider__item js-special-slider__item">
            <div class="special-slider__product-card">
                <article class="special-offer__card">';
        $html .= Html::a('', ['shop/vendor', 'number' => $model['article_number'],], ['class' => 'special-offer__card-link',]);
        if ($model['offer_type'] === SpecialOffers::OFFER_TYPE_FLAG) {
            $html .= '<div class="special-offer__stock" '.(!empty($model['color']) ? ' style="background-color: '.$model['color'].';"' : '').'>'.$model['offer_name'].'</div>';
        }
        if (!empty($model['image'])) {
            $html .= Html::tag('div', Html::img($model['image'], ['width' => '180',]), ['class' => 'special-offer__card-photo',]);
        }

        $html .= '<div class="special-offer__card-departament"><p>'. $model['title'].'</p></div>
                    <div class="special-offer__card-descr"><p>'.$model['product_name'].'</p></div>
                    <div class="special-offer__card-bottom">';
        $html .= '<div class="special-offer__card-price">';
        if (!empty($model['price'])) {
            $html .= '<span>Цена от:</span><div class="rub">'.number_format($model['price'], 0, '.', ' ').'</div>';
        } else {
            $html .= '<span>Цена:</span><div class="rub--no-price">По запросу</div>';
        }
        $html .= '</div>';
        $html .= '<div class="special-offer__card-buttons">';
        $html .= '<div class="special-offer-card__favorite-wrapper">
            <div class="special-offer-card__favorite--default" data-key="'.$model['article_number'].'">
                <div class="special-offer-card__favorite-default-tip">Добавить в избранное</div>
            </div>
            <div class="special-offer-card__favorite--active'.(FavoriteHelper::isFavorite($model['article_number']) ? ' special-offer-card__favorite--active-on' : '').'" data-key="'.$model['article_number'].'">
                <div class="special-offer-card__favorite-active-tip">Удалить из избранного</div>
            </div>
        </div>';

        if (false/*!empty($model['price'])*/) {
            $html .= '<div class="special-offer-card__buy-btn-wrapper">
                <div class="special-offer-card__buy-btn--default">
                    <div class="special-offer-card__buy-btn-default-tip" data-key="' . $model['article_number'] . '">Добавить в корзину</div>
                </div>
                <div class="special-offer-card__buy-btn--active'.(CartHelper::isArticleInCart($model['article_number']) ? ' special-offer-card__buy-btn--active-on' : '').'">
                    <div class="special-offer-card__buy-btn-active-tip" data-key="' . $model['article_number'] . '">Товар в корзине</div>
                </div>
            </div>';
        }

        $html .= '</div></div>
                </article>
            </div>
        </div>
        ';

        return $html;
    }

    /**
     * @param array $model
     *
     * @return string
     */
    public static function getSpecialPageOfferHtml(array $model) : string
    {
        $html = '
        <article class="special-offer-catalog__card">';
        $html .= Html::a('', ['shop/vendor', 'number' => $model['article_number'],], ['class' => 'special-offer__card-link',]);
        if ($model['offer_type'] === SpecialOffers::OFFER_TYPE_FLAG) {
            $html .= '<div class="special-offer__stock" '.(!empty($model['color']) ? ' style="background-color: '.$model['color'].';"' : '').'>'.$model['offer_name'].'</div>';
        }
        if (!empty($model['image'])) {
            $html .= Html::tag('div', Html::img($model['image'], ['width' => '180',]), ['class' => 'special-offer__card-photo',]);
        }


        $html .= '<div class="special-offer-catalog__card-departament"><p>'. $model['title'].'</p></div>
            <div class="special-offer-catalog__card-descr"><p>'.$model['product_name'].'</p></div>
            <div class="special-offer-catalog__card-bottom">';

        $html .= '<div class="special-offer-catalog__card-price">';
        if (!empty($model['price'])) {
            $html .= '<span>Цена от:</span><div class="catalog-rub">'.number_format($model['price'], 0, '.', ' ').'</div>';
        } else {
            $html .= '<span>Цена:</span><div class="catalog-rub--no-price">По запросу</div>';
        }
        $html .= '</div>';

        $html .= '
            <div class="special-offer-catalog__card-buttons">
                <div class="special-offer-catalog__card-favorite-wrapper">
                    <div class="special-offer-catalog__card-favorite--default" data-key="'.$model['article_number'].'">
                        <div class="special-offer-catalog__card-favorite-default-tip">Добавить в избранное</div>
                    </div>
                    <div class="special-offer-catalog__card-favorite--active'.(FavoriteHelper::isFavorite($model['article_number']) ? ' special-offer-catalog__card-favorite--active-on' : '').'" data-key="'.$model['article_number'].'">
                        <div class="special-offer-catalog__card-favorite-active-tip">Удалить из избранного</div>
                    </div>
                </div>';

        if (false/*!empty($model['price'])*/) {
            $html .= '
                <div class="special-offer-catalog__card-buy-btn-wrapper">
                    <div class="special-offer-catalog__card-buy-btn--default">
                        <div class="special-offer-catalog__card-buy-btn-default-tip" data-key="'.$model['article_number'].'">Добавить в корзину</div>
                    </div>
                    <div class="special-offer-catalog__card-buy-btn--active'.(CartHelper::isArticleInCart($model['article_number']) ? ' special-offer-catalog__card-buy-btn--active-on' : '').'">
                        <div class="special-offer-catalog__card-buy-btn-active-tip" data-key="'.$model['article_number'].'">Товар в корзине</div>
                    </div>
                </div>';
        }
        $html .= '</div>';

        $html .= '
            </div>
        </article>';

//            $html .= print_r($model, true);

        return $html;
    }

    /**
     * @param string $code
     *
     * @return array
     */
    public static function scanCatalogImages(string $code) : array
    {
        $list = [];
        $dir = \Yii::getAlias('@frontendImages').DIRECTORY_SEPARATOR.Catalog::IMAGES_DIR_LR;

        if (file_exists($dir)) {
            foreach (glob($dir.DIRECTORY_SEPARATOR.$code.Catalog::IMAGE_SEPARATOR.'*.*') as $filename) {
                $filename = str_ireplace($dir.DIRECTORY_SEPARATOR, "", $filename);
                preg_match('/^'.$code.'__(\d+)\..*?$/i', $filename, $matches);

                if ($matches) {
                    $list[$matches[1]] = DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.Catalog::IMAGES_DIR_LR.DIRECTORY_SEPARATOR.$matches[0];
                }
            }
        }

        ksort($list);

        return $list;
    }

    /**
     * @param string $images
     *
     * @return array
     */
    public static function catalogImagesSizes(string $images) : array
    {
        $sizes = [];
        list($width, $height) = getimagesize(Url::base(true).$images);

        $sizes['width'] = $width;
        $sizes['height'] = $height;

        return $sizes;
    }

    /**
     * @param Articles $article
     *
     * @return int|float
     * @throws NotFoundHttpException
     */
    public static function getArticleMinPrice(Articles $article)
    {
        $dataProvider = (new ArticleItemSearch())
            ->setArticle($article)
            ->search([]);

        $prices = [];
        /** @var FullPrice $model */
        foreach ($dataProvider->getModels() as $model) {
            if (is_numeric($model->price)) {
                $prices[$model->id] = $model->price;
            }
        }

        if ($prices) {
            sort($prices);

            return array_shift($prices);
        }

        return 0;
    }

    /**
     * @param array  $data
     * @param string $parentID
     */
    public static function printCatalogListHtml2(array $data, string $parentID) : void
    {
        foreach ($data as $code => $row) {
            echo '<h4>'.$row['code'].' '.$row['name'].'</h4>';

            if (!empty($row['children'])) {
                foreach ($row['children'] as $childrenCode => $children) {
                    echo '<h6>Children '.$children['code'].' '.$children['name'].'</h6>';
                    if (!empty($children['children'])) {
                        self::printCatalogListHtml($children['children'], $childrenCode);
                    }
                }
            }

            echo '<hr>';
        }

   }
    /**
     * @param array  $data
     * @param string $parentID
     */
    public static function printCatalogListHtml(array $data, int $parentID) : void
    {
        $parentHtmlID = 'accordion'.$parentID;
        echo '<div id="'.$parentHtmlID.'" role="tablist" aria-multiselectable="true">';

        foreach ($data as $code => $row) {
            $headingID = 'accordionHeading'.$code;
            $bodyID = 'accordionBody'.$code;

            echo '<div class="card">
                <div class="card-header" role="tab" id="'.$headingID.'">
                    <div class="mb-0 row">
                        <div class="col-12 no-padding accordion-head">
                            <a data-toggle="collapse" data-parent="#'.$parentHtmlID.'" href="#'.$bodyID.'" aria-expanded="false" aria-controls="'.$bodyID.'" class="collapsed">
                                <i class="fas fa-minus"></i>
                                <h3>'.$row['name'].'</h3>
                            </a>
                        </div>
                    </div>
                </div>

                <div id="'.$bodyID.'" class="collapse" role="tabpanel" aria-labelledby="'.$headingID.'" aria-expanded="false">
                    <div class="card-block col-12">
                        <img style="float: left; padding-right: 40px;" src="'.self::getCatalogTopLevelImageUrl($row['code']).'" alt="">
                        <p>'.$row['description'].'</p>';

                        if (!empty($row['children'])) {
                            $childrenID = 'accordion'.($parentID + 1)/*$code*/;

                            echo '<div id="'.$childrenID.'" role="tablist" aria-multiselectable="true">';
                            foreach ($row['children'] as $childrenCode => $children) {
                                $childrenHeadingID = 'accordionHeading'.$childrenCode;
                                $childrenBodyID = 'accordionBody'.$childrenCode;

                                echo '<div class="card">
                                    <div class="card-header" role="tab" id="'.$childrenHeadingID.'">
                                        <div class="mb-0 row">
                                            <div class="col-12 no-padding accordion-head">
                                                <a data-toggle="collapse" data-parent="#'.$childrenID.'" href="#'.$childrenBodyID.'" aria-expanded="false" aria-controls="'.$childrenBodyID.'" class="collapsed">
                                                    <i class="fas fa-minus"></i>
                                                    <h3>'.$children['name'].'</h3>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="'.$childrenBodyID.'" class="collapse" role="tabpanel" aria-labelledby="'.$childrenHeadingID.'" aria-expanded="false">
                                        <div class="card-block col-12">
                                            <img style="float: left; padding-right: 40px;" src="'.self::getCatalogTopLevelImageUrl($children['code']).'" alt="">
                                            <p>'.$children['description'].'</p>';

                                            if (!empty($children['children'])) {
                                                self::printCatalogListHtml($children['children'], ($parentID + 2)/*$childrenCode*/);
                                            }
                                        echo '</div>
                                    </div>
                                </div>';
                            }
                            echo '</div>';
                        }
                    echo '</div>
                </div>
            </div>';
        }
        echo '</div>';
    }

    /**
     * @return CatalogTreeSetting
     */
    public static function getCatalogTreeSetting() : CatalogTreeSetting
    {
        if (($model = CatalogTreeSetting::find()->one()) !== null) {
            return $model;
        }

        $model = new CatalogTreeSetting();
        $model->row_count_desktop = CatalogTreeSetting::DEFAULT_ROW_COUNT_DESKTOP;
        $model->row_count_laptop = CatalogTreeSetting::DEFAULT_ROW_COUNT_LAPTOP;
        $model->row_count_mobile = CatalogTreeSetting::DEFAULT_ROW_COUNT_MOBILE;
        $model->header_font_size = CatalogTreeSetting::DEFAULT_HEADER_FONT_SIZE;
        $model->grid_height = CatalogTreeSetting::DEFAULT_GRID_HEIGHT;

        return $model;
    }

    /**
     * @param string $code
     * @param bool   $withProducts
     *
     * @return mixed
     */
    public static function getCatalogListData(string $code, bool $withProducts = false)
    {
        $cache = \Yii::$app->cache;
        $key = CatalogListWidget::CACHE_KEY.'_'.$code.'_'.intval($withProducts);

        return $cache->getOrSet($key, function () use ($code, $withProducts) {
            return (new CatalogListSearch())->search(['code' => $code, 'with_products' => $withProducts,]);
        }, CatalogListWidget::CACHE_DURATION);
    }

    /**
     * @return array
     */
    public static function getCatalogGroupDepartmentsData()
    {
        $cache = \Yii::$app->cache;
        $key = CatalogListWidget::CACHE_CATALOG_GROUP_DEPARTMENT.'_'.Catalog::ITEM_GROUPS_CODE;
        //$cache->delete($key);

        return $cache->getOrSet($key, function () {
            $query = Catalog::find()->orderBy([Catalog::tableName() . '.order' => SORT_ASC, Catalog::tableName() . '.name' => SORT_ASC,]);
            $query->select([Catalog::tableName().'.code', Catalog::tableName().'.copy_of', Catalog::tableName().'.name', Catalog::tableName().'.title', Catalog::tableName().'.link_anchor', Department::tableName().'.url',]);
            $query->innerJoin(Department::tableName(), Department::tableName().'.catalog_code = '.Catalog::tableName().'.code');
            $query->where([Catalog::tableName().'.parent_code' => Catalog::ITEM_GROUPS_CODE, Catalog::tableName() . '.is_department' => true, Department::tableName().'.is_active' => true,]);
            $query->asArray()->indexBy('code');

            return $query->all();
        }, CatalogListWidget::CACHE_DURATION);
    }

    /**
     * All catalog rows without products indexed by code
     *
     * @return array
     */
    public static function getCatalogStructureData()
    {
        $cache = \Yii::$app->cache;
        $key = CatalogListWidget::CACHE_CATALOG_STRUCTURE_DATA;
        //$cache->delete($key);

        return $cache->getOrSet($key, function () {
            $query = Catalog::find()->where(['is_product' => Catalog::IS_PRODUCT_NO,]);
            $query->asArray()->indexBy('code');

            return $query->all();
        }, CatalogListWidget::CACHE_CATALOG_STRUCTURE_DATA_DURATION);
    }

    /**
     * @param Catalog $model
     *
     * @return mixed
     */
    public static function getCatalogTreeData(Catalog $model)
    {
        $cache = \Yii::$app->cache;
        $key = CatalogListWidget::CACHE_TREE_KEY.'_'.$model->code;
//        $cache->delete($key);

        return $cache->getOrSet($key, function () use ($model) {
            return (new CatalogTreeSearch())->searchTreeFromTopLevel($model);
        }, CatalogListWidget::CACHE_DURATION);
    }

    /**
     * @param array  $data
     * @param string $nodeCode
     *
     * @return array
     */
    public static function getCatalogBreadcrumbs(array $data, string $nodeCode) : array
    {
        $breadcrumbs = [];

        foreach ($data as $code => $row) {
            if ($code === $nodeCode) {
                $breadcrumbs[] = ['label' => $row['name'], 'url' => ['/shop/code', 'code' => $row['code'],], 'template' => self::BREADCRUMB_TEMPLATE, 'class' => 'bc code-'.$row['code'],];

                break;
            }

            if (!empty($row['children'])) {
                foreach ($row['children'] as $childrenCode => $children) {
                    if ($childrenCode === $nodeCode) {
                        $breadcrumbs[] = ['label' => $row['name'], 'url' => ['/shop/code', 'code' => $row['code'],], 'template' => self::BREADCRUMB_TEMPLATE, 'class' => 'bc code-'.$row['code'],];
                        $breadcrumbs[] = ['label' => $children['name'], 'url' => ['/shop/code', 'code' => $children['code'],], 'template' => self::BREADCRUMB_TEMPLATE, 'class' => 'bc code-'.$children['code'],];

                        return $breadcrumbs;
                    }

                    if (!empty($children['children'])) {
                        $b = self::getCatalogBreadcrumbs($children['children'], $nodeCode);

                        if ($b) {
                            $breadcrumbs[] = ['label' => $row['name'], 'url' => ['/shop/code', 'code' => $row['code'],], 'template' => self::BREADCRUMB_TEMPLATE, 'class' => 'bc code-'.$row['code'],];
                            $breadcrumbs[] = ['label' => $children['name'], 'url' => ['/shop/code', 'code' => $children['code'],], 'template' => self::BREADCRUMB_TEMPLATE, 'class' => 'bc code-'.$children['code'],];

                            $breadcrumbs = ArrayHelper::merge($breadcrumbs, $b);

                            return $breadcrumbs;
                        }
                    }
                }
            }
        }

        return $breadcrumbs;
    }

    /**
     * @param $price
     *
     * @return string
     */
    public static function formatPrice($price) : string
    {
        return is_numeric($price) ? number_format($price, 0, '.', ' ') : '';
    }

    /**
     * @param array $article
     *
     * @return string
     */
    public static function getCardProductMobileHtml(array $article) : string
    {
        $finalVendorUrl = self::generateVendorURLs($article['number']);

        $stocks = $filterHide = $favIcon = '';
        $isFavorite = \common\components\helpers\FavoriteHelper::isFavorite($article['number']);
        if (count($article['products']) <= 1) {
            $filterHide = 'display: none;';
        }
        if ($isFavorite) {
            $favIcon = 'short-options-mobile__favorite-active--on';
        }
        if (!empty($article['offers'])) {
            foreach ($article['offers'] as $name => $color) {
                $stocks .= Html::tag('div', $name, ['class' => 'short-options-mobile__stock', 'style' => 'background-color: '.$color.';',]);
            }
        }
        if (!empty($article['image'])) {
            $image = Html::a(Html::img($article['image']), $finalVendorUrl);
        } else {
            $image = Html::a(Html::img('/img/'.Catalog::IMAGE_NOT_AVAILABLE_180), $finalVendorUrl);
        }
        $noOffersTitleClass = 'short-mobile-card__title';
        $noOffersCodeClass = 'short-mobile-card__vendor-code';
        if (!empty($article['price'])) {
            $price = Html::tag('div', 'От '.Html::tag('div', self::formatPrice($article['price']), ['class' => 'offers-rub',]), ['class' => 'short-panel-mobile__price',]);
            $allPrices = Html::tag('div', 'Все цены', ['class' => 'short-panel-mobile__open',]);
            $stocksHtml = Html::tag('div', $stocks, ['class' => 'short-options-mobile__stocks',]);
        } else {
            $noOffersTitleClass = 'short-mobile-card__title--no-offers';
            $noOffersCodeClass = 'short-mobile-card__vendor-code--no-offers';
            $price = Html::tag('div', 'Нет предложений', ['class' => 'short-panel-mobile__no-offers',]);
            $allPrices = Html::tag('div', 'Запросить', ['class' => 'short-panel-mobile__make-request',]);
            $stocksHtml = '';
        }

        $html = '
        <div class="offer-card-mobile-wrapper">
            <div class="offer-card-mobile-separator"></div>
    
            <article class="offer-card-mobile">
                <div class="offer-card-mobile__short short-mobile-card">
                    <div class="short-mobile-card__options short-options-mobile">
                        <a class="short-options-mobile__favorite" data-key="'.$article['number'].'"></a>
                        <a class="short-options-mobile__favorite-active '.$favIcon.'" data-key="'.$article['number'].'"></a>
                        '.$stocksHtml.'
                    </div>
                    <div class="short-mobile-card__img">'.$image.'</div>
                    '.Html::a('<div class="'.$noOffersCodeClass.'">'.$article['number'].'</div>
                    <div class="'.$noOffersTitleClass.'">'.$article['name'].'</div>', '/product/'.$article['number'], ['class' => 'short-mobile-card__links',]).'
                    <div class="short-mobile-card__text">'.self::parseCardItemDescription($article['description'], $article['number'], 'short-mobile-card').'</div>
                    <div class="short-mobile-card__panel short-panel-mobile">
                        '.$price.'
                        '.$allPrices.'
                    </div>
                </div>
                <div class="offer-card-mobile__full full-mobile-card">
                    <div class="mobile-filter__close">Скрыть</div>
                    <!-- Filter -->
                    <div class="full-mobile-card__filter mobile-filter" style="'.$filterHide.'">
                        <p class="mobile-filter__text">Сортировать:</p>
                        <div class="mobile-filter__price offers-mobile-filter-price">
                            по цене
                            <ul class="offers-mobile-filter-price__list">
                                <li class="offers-mobile-filter-price__item">дешевле</li>
                                <li class="offers-mobile-filter-price__item">дороже</li>
                            </ul>
                        </div>
                        
                    </div>';
        $html .= '<div class="full-mobile-card__list">';
        foreach ($article['products'] as $product) {
            $delivery_text = '';
            $delivery_color = '';
            if (!empty($product['delivery_code'])) {
                $delivery_data = self::getDeliveryTimeText($product['delivery_code']);
                $delivery_type = mb_strtolower($delivery_data['delivery']);
                $delivery_time = mb_strtolower($delivery_data['delivery_time']);
                if ($delivery_type == $delivery_time) {
                    $delivery_text = $delivery_type;
                } else {
                    $delivery_text = $delivery_type . ', ' . $delivery_time;
                }
                $delivery_text = mb_convert_case($delivery_text, MB_CASE_TITLE, "UTF-8");
                $delivery_color = $delivery_data['color'];
            }
            $stocks = '';
            if (!empty($product['offers'])) {
                foreach ($product['offers'] as $name => $color) {
                    $stocks .= Html::tag('div', $name, ['class' => 'mobile-buy__best-price', 'style' => 'color: '.$color.';',]);
                }
            }

            $availability = $product['availability'];
            $isAvailabilityInt = intval($availability) > 0;
            $replacement = !empty($product['cross_type']) ? '<div class="mobile-properties__replacement" title="'.$product['cross_type'].'">'.$product['cross_type'].'</div>' : '';

            $priceClass = 'mobile-buy__price';
            if (!empty($stocks)) {
                $priceClass .= ' mobile-buy__price--best';
            }
            if (!is_numeric($product['price'])) {
                $priceClass = 'mobile-buy__price--optional';
            }

            $buyBtns = '';
            if (is_numeric($product['price'])) {
                $buyBtns = '<div class="mobile-buy__btns">
                    <a href="#" class="mobile-buy__fast-buy-btn" data-key="'.$product[PriceList::PRODUCT_KEY].'" data-availability="'.$product['availability'].'"></a>
                    <a href="#" class="mobile-buy__buy-btn" data-key="'.$product[PriceList::PRODUCT_KEY].'" data-availability="'.$product['availability'].'"></a>
                </div>';
            }

            $html .= '<div class="full-mobile-card__wrapper mobile-list-item">
                        <div class="mobile-list-item__inner">
                            <div class="mobile-list-item__properties mobile-properties">
                                <div class="mobile-properties__manufacturer">'.$product['manufacturer'].'</div>
                                <div class="mobile-properties__quality">'.$product['quality'].'</div>
                                '.$replacement.'
                                <div class="mobile-properties__states">
                                    '.(!empty($product['commentary']) ? '<div class="mobile-properties__state--attention"></div>' : '').'
                                    '.(!empty($product['cross_type']) ? '<div class="mobile-properties__state--replacement"></div>' : '').'
                                    '.(!empty($product['code']) && $product['code'] === PriceList::CODE_PRICE_LR_RU ? '<div class="mobile-properties__state--showroom"></div>' : '').'
                                </div>
                            </div>
                            <div class="mobile-list-item__description mobile-description">
                                <div class="mobile-description__delievery" style="color: '.$delivery_color.';">'.$delivery_text.'</div>
                                <div class="mobile-description__quantity">'.($isAvailabilityInt ? $availability.' шт' : $availability).'</div>
                            </div>
                            <div class="mobile-list-item__buy mobile-buy">
                                <div class="'.$priceClass.'">'.(is_numeric($product['price']) ? self::formatPrice($product['price']) : $product['price']).'</div>
                                '.$stocks.$buyBtns.'
                            </div>
                        </div>
    
                        <div class="mobile-list-item__info-inner mobile-info">
                            <div class="mobile-info__links">
                                <a href="'.Url::to(self::generateProductURLs($article['number'], $product[PriceList::PRODUCT_KEY])).'" class="mobile-info__link">Перейти на страницу товара</a>
                                <a href="'.Url::to($finalVendorUrl).'" class="mobile-info__link">все варианты поставки данного товара</a>
                            </div>';
                            if ($product['code'] === PriceList::CODE_PRICE_LR_RU || !empty($product['commentary']) || !empty($product['quality'])) {
                                $html .= '<div class="mobile-info__items"><div class="mobile-info__items-close"></div>';
                                if (!empty($product['commentary'])) {
                                    $html .= '
                                    <div class="mobile-info__item mobile-info-item">
                                        <div class="mobile-info-item__title">
                                            <div class="mobile-info-item__title--attention"></div>
                                        </div>
                                        <div class="mobile-info-item__text mobile-info-item__text--attention">'.$product['commentary'].'</div>
                                    </div>';
                                }
                                if ($product['code'] === PriceList::CODE_PRICE_LR_RU) {
                                    $html .= '
                                    <div class="mobile-info__item mobile-info-item">
                                        <div class="mobile-info-item__title">
                                            <div class="mobile-info-item__title--showroom"></div>
                                        </div>
                                        <div class="mobile-info-item__text mobile-info-item__text--attention">Товар имеется в шоу-руме LR.RU</div>
                                    </div>';
                                }
                                if (!empty($product['quality'])) {
                                    $html .= '
                                        <div class="mobile-info__item mobile-info-item">
                                            <div class="mobile-info-item__title">
                                                '.$product['quality'].'
                                            </div>
                                            <div class="mobile-info-item__text">
                                            </div>
                                        </div>
                                    ';
                                }
                                $html .= '</div>';
                            }
                            $html .= '    </div>
                    </div>';
        }
        $html .= '</div>';
        $html .= '</div>
            </article>
        </div>';

        return $html;
    }

    /**
     * @param array $article
     *
     * @return string
     */
    public static function getCardProductMobilePageHtml(array $article) : string
    {
        $finalVendorUrl = self::generateVendorURLs($article['number']);
        $html = '
        <div class="offers-vendor-catalog-mobile__offer">
            <div class="offer-card-mobile__full">
                <div class="full-mobile-card__filter mobile-filter">
                    <p class="mobile-filter__text">Сортировать:</p>
                    <div class="mobile-filter__price offers-mobile-filter-price">
                            по цене
                            <ul class="offers-mobile-filter-price__list">
                                <li class="offers-mobile-filter-price__item">дешевле</li>
                                <li class="offers-mobile-filter-price__item">дороже</li>
                            </ul>
                        </div>
                </div>';

        foreach ($article['products'] as $product) {
            $delivery_text = '';
            $delivery_color = '';
            if (!empty($product['delivery_code'])) {
                $delivery_data = self::getDeliveryTimeText($product['delivery_code']);
                $delivery_type = mb_strtolower($delivery_data['delivery']);
                $delivery_time = mb_strtolower($delivery_data['delivery_time']);
                if ($delivery_type == $delivery_time) {
                    $delivery_text = $delivery_type;
                } else {
                    $delivery_text = $delivery_type . ', ' . $delivery_time;
                }
                $delivery_text = mb_convert_case($delivery_text, MB_CASE_TITLE, "UTF-8");
                $delivery_color = $delivery_data['color'];
            }
            $stocks = '';
            if (!empty($product['offers'])) {
                foreach ($product['offers'] as $name => $color) {
                    $stocks .= Html::tag('div', $name, ['class' => 'mobile-buy__best-price', 'style' => 'color: '.$color.';',]);
                }
            }

            $availability = $product['availability'];
            $isAvailabilityInt = intval($availability) > 0;
            $replacement = !empty($product['cross_type']) ? '<div class="mobile-properties__replacement" title="'.$product['cross_type'].'">'.$product['cross_type'].'</div>' : '';

            $priceClass = 'mobile-buy__price';
            if (!empty($stocks)) {
                $priceClass .= ' mobile-buy__price--best';
            }
            if (!is_numeric($product['price'])) {
                $priceClass = 'mobile-buy__price--optional';
            }

            $buyBtns = '';
            if (is_numeric($product['price'])) {
                $buyBtns = '<div class="mobile-buy__btns">
                    <a href="#" class="mobile-buy__fast-buy-btn" data-key="'.$product[PriceList::PRODUCT_KEY].'" data-availability="'.$product['availability'].'"></a>
                    <a href="#" class="mobile-buy__buy-btn" data-key="'.$product[PriceList::PRODUCT_KEY].'" data-availability="'.$product['availability'].'"></a>
                </div>';
            }

            $html .= '<div class="full-mobile-card__wrapper mobile-list-item">
                        <div class="mobile-list-item__inner">
                            <div class="mobile-list-item__properties mobile-properties">
                                <div class="mobile-properties__manufacturer">'.$product['manufacturer'].'</div>
                                <div class="mobile-properties__quality">'.$product['quality'].'</div>
                                '.$replacement.'
                                <div class="mobile-properties__states">
                                    '.(!empty($product['commentary']) ? '<div class="mobile-properties__state--attention"></div>' : '').'
                                    '.(!empty($product['cross_type']) ? '<div class="mobile-properties__state--replacement"></div>' : '').'
                                    '.(!empty($product['code']) && $product['code'] === PriceList::CODE_PRICE_LR_RU ? '<div class="mobile-properties__state--showroom"></div>' : '').'
                                </div>
                            </div>
                            <div class="mobile-list-item__description mobile-description">
                                <div class="mobile-description__delievery" style="color: '.$delivery_color.';">'.$delivery_text.'</div>
                                <div class="mobile-description__quantity">'.($isAvailabilityInt ? $availability.' шт' : $availability).'</div>
                            </div>
                            <div class="mobile-list-item__buy mobile-buy">
                                <div class="'.$priceClass.'">'.(is_numeric($product['price']) ? self::formatPrice($product['price']) : $product['price']).'</div>
                                '.$stocks.$buyBtns.'
                            </div>
                        </div>
    
                        <div class="mobile-list-item__info-inner mobile-info">
                            <div class="mobile-info__links">
                                <a href="'.Url::toRoute(['shop/vendor', 'number' => $article['number'], 'key' => $product[PriceList::PRODUCT_KEY]]).'" class="mobile-info__link">Перейти на страницу товара</a>
                            </div>';
            if ($product['code'] === PriceList::CODE_PRICE_LR_RU || !empty($product['commentary']) || !empty($product['quality'])) {
                $html .= '<div class="mobile-info__items"><div class="mobile-info__items-close"></div>';
                if (!empty($product['commentary'])) {
                    $html .= '
                    <div class="mobile-info__item mobile-info-item">
                        <div class="mobile-info-item__title">
                            <div class="mobile-info-item__title--attention"></div>
                        </div>
                        <div class="mobile-info-item__text mobile-info-item__text--attention">'.$product['commentary'].'</div>
                    </div>';
                }
                if ($product['code'] === PriceList::CODE_PRICE_LR_RU) {
                    $html .= '
                    <div class="mobile-info__item mobile-info-item">
                        <div class="mobile-info-item__title">
                            <div class="mobile-info-item__title--showroom"></div>
                        </div>
                        <div class="mobile-info-item__text mobile-info-item__text--attention">Товар имеется в шоу-руме LR.RU</div>
                    </div>';
                }
                if (!empty($product['quality'])) {
                    $html .= '
                        <div class="mobile-info__item mobile-info-item">
                            <div class="mobile-info-item__title">
                                '.$product['quality'].'
                            </div>
                            <div class="mobile-info-item__text">
                            </div>
                        </div>
                    ';
                }
                $html .= '</div>';
            }
            $html .= '</div>';
        }

        $html .= '</div></div>';

        return $html;
    }

    /**
     * @param array $article
     *
     * @return string
     */
    public static function getCardProductDesktopHtml(array $article) : string
    {   
        $finalVendorUrl = self::generateVendorURLs($article['number']);

        $stocks = $filterHide = $favIcon = '';
        $isFavorite = \common\components\helpers\FavoriteHelper::isFavorite($article['number']);
        if (count($article['products']) <= 1) {
            $filterHide = 'display: none;';
        }
        if ($isFavorite) {
            $favIcon = 'short-options-desktop__favorite-active--on';
        }
        if (!empty($article['offers'])) {
            foreach ($article['offers'] as $name => $color) {
                $stocks .= Html::tag('div', $name, ['class' => 'short-options-desktop__stock', 'style' => 'background-color: '.$color.';',]);
            }
        }
        if (!empty($article['image'])) {
            $image = Html::a(Html::img($article['image']), $finalVendorUrl);
        } else {
            $image = Html::a(Html::img('/img/'.Catalog::IMAGE_NOT_AVAILABLE_180), $finalVendorUrl);
        }
        $noOffersCodeClass = 'short-card-description__vendor-code';
        $noOffersTitleClass = 'short-card-description__title';
        if (!empty($article['price'])) {
            $price = Html::tag('div', 'От '.Html::tag('div', self::formatPrice($article['price']), ['class' => 'offers-rub',]), ['class' => 'short-panel-desktop__price',]);
            $allPrices = Html::tag('div', 'Все цены', ['class' => 'short-panel-desktop__open',]);
            $stocksHtml = Html::tag('div', $stocks, ['class' => 'short-options-desktop__stocks',]);
        } else {
            $price = '';
            $allPrices = Html::tag('div', 'Запросить', ['class' => 'short-panel-desktop__make-request',]);
            $stocksHtml = Html::tag('div', 'Нет предложений', ['class' => 'short-options-desktop__no-offers',]);
            $noOffersCodeClass = 'short-card-description__vendor-code short-card-description__vendor-code--no-offers';
            $noOffersTitleClass = 'short-card-description__title short-card-description__title--no-offers';
        }
        $html = '
        <div class="offer-card-desktop-wrapper">
            <div class="offer-card-separator"></div>

            <article class="offer-card-desktop">
                <div class="offer-card-desktop__options short-options-desktop">
                    <a class="short-options-desktop__favorite" data-key="'.$article['number'].'"></a>
                    <a class="short-options-desktop__favorite-active '.$favIcon.'" data-key="'.$article['number'].'"></a>
                    
                    <div class="short-options-desktop__favorite-tooltip">
                        <div class="short-options-desktop__favorite-tooltip-icon"></div>
                        <div class="short-options-desktop__favorite-tooltip-text">Добавить в Избранное</div>
                    </div>
                    '.$stocksHtml.'
                </div>

                <div class="offer-card-desktop__short short-desktop-card">
                    <div class="short-desktop-card__picture">'.$image.'</div>
                    <div class="short-desktop-card__description short-card-description">
                        '.Html::a('', $finalVendorUrl, ['class' => 'short-card-description__link', 'target' => '_blank']).'
                        <div class="'.$noOffersCodeClass.'">'.$article['number'].'</div>
                        <div class="'.$noOffersTitleClass.'">'.$article['name'].'</div>
                        <div class="short-card-description__text">'.self::parseCardItemDescription($article['description'], $article['number'], 'short-card-description').'</div>
                    </div>
                    <div class="short-desktop-card__panel short-panel-desktop">
                        '.$price.'
                        '.$allPrices.'
                        <!--div class="offers-catalog-desktop__help-second">
                            Кликнув по этой кнопке посмотри товарные предложения прямо здесь!
                            <button class="offerCardDesktopHelpBtnSecond">Хорошо</button>
                        </div-->
                    </div>
                </div>

                <div class="offer-card-desktop__full full-desktop-card">
                    <!-- Filter -->
                    <div class="full-desktop-card__filter desktop-filter">
                        <p class="desktop-filter__text" style="">Сортировать:</p>
                        <div class="desktop-filter__price offers-desktop-filter-price" style="">
                            по цене
                            <ul class="offers-desktop-filter-price__list">
                                <li class="offers-desktop-filter-price__item">дешевле</li>
                                <li class="offers-desktop-filter-price__item">дороже</li>
                            </ul>
                        </div> 
                        <div class="desktop-filter__delivery-date" style="display: none">по сроку доставки</div>
                        <div class="desktop-filter__close">Скрыть</div>
                    </div>                
                    <!-- offers-list -->
                    <div class="full-desktop-card__list">';
        foreach ($article['products'] as $product) {
            $delivery_text = '';
            $delivery_color = '';
            if (!empty($product['delivery_code'])) {
                $delivery_data = self::getDeliveryTimeText($product['delivery_code']);
                $delivery_type = mb_strtolower($delivery_data['delivery']);
                $delivery_time = mb_strtolower($delivery_data['delivery_time']);
                if ($delivery_type == $delivery_time) {
                    $delivery_text = $delivery_type;
                } else {
                    $delivery_text = $delivery_type . ', ' . $delivery_time;
                }
                $delivery_text = mb_convert_case($delivery_text, MB_CASE_TITLE, "UTF-8");
                $delivery_color = $delivery_data['color'];
            }
            $stocks = '';
            if (!empty($product['offers'])) {
                foreach ($product['offers'] as $name => $color) {
                    $stocks .= Html::tag('div', $name,
                        ['class' => 'desktop-card-item__best-price', 'style' => 'color: ' . $color . ';',]);
                }
            }

            $availability = $product['availability'];
            $isAvailabilityInt = intval($availability) > 0;
            $replacement = !empty($product['cross_type']) ? '<div class="desktop-properties__replacement" title="'.$product['cross_type'].'">  </div>' : '';

            $priceClass = 'desktop-card-item__price';
            if (!empty($stocks)) {
                $priceClass .= ' desktop-card-item__price--best';
            }
            if (!is_numeric($product['price'])) {
                $priceClass = 'desktop-card-item__price--optional';
            }
            $html .= '
                <div class="full-desktop-card__item desktop-card-item">
                    <div class="desktop-card-item__inner">
                        <div class="desktop-card-item__properties desktop-properties">
                            <div class="desktop-properties__wrapper">
                                <div class="desktop-properties__manufacturer">' . $product['manufacturer'] . '</div>
                                <div class="desktop-properties__inner">
                                    <div class="desktop-properties__quality">' . $product['quality'] . '</div>
                                </div>
                            </div>
                            <div class="desktop-properties__icons">
                                ' . (!empty($product['commentary']) ? '<div class="desktop-properties__icons--attention"></div>' : '') . '
                                ' . (!empty($product['code']) && $product['code'] === PriceList::CODE_PRICE_LR_RU ? '<div class="desktop-properties__icons--showroom"></div>' : '') . '                                    
                            </div>
                        </div>
                        <div class="desktop-card-item__price-inner">
                            <div class="'. $priceClass.'">'.(is_numeric($product['price']) ? self::formatPrice($product['price']) : $product['price']).'</div>
                            ' . $stocks . '
                        </div>
                        <div class="desktop-card-item__description desktop-description">
                            <div class="desktop-description__shop">' . ($isAvailabilityInt ? $availability . ' <span>шт</span>' : $availability) . '</div>
                            <div class="desktop-description__delievery" style="color: '.$delivery_color.';">'.$delivery_text.'</div>
                        </div>
            ';
            if (is_numeric($product['price'])) {
                $html .= '
                <div class="desktop-card-item__buy desktop-buy">
                    <a href="" class="desktop-buy__fast-buy-btn" data-key="'.$product[PriceList::PRODUCT_KEY].'" data-availability="'.$product['availability'].'"></a>
                    <a href="" class="desktop-buy__buy-btn" data-key="'.$product[PriceList::PRODUCT_KEY].'" data-availability="'.$product['availability'].'"></a>
                </div>
                ';
            }

            $html .= '
                </div>
                <div class="desktop-card-item__info desktop-info">
                    <div class="desktop-info__links">
                        <a href="'.Url::to(self::generateProductURLs($article['number'], $product[PriceList::PRODUCT_KEY])).'" class="desktop-info__link" target="_blank">Перейти на страницу товара</a>
                        <a href="'.Url::to($finalVendorUrl).'" class="desktop-info__link" target="_blank">все варианты поставки данного товара</a>
                    </div>';
            if ($product['code'] === PriceList::CODE_PRICE_LR_RU || !empty($product['commentary']) || !empty($product['quality'])) {
            $html .= '
                <div class="desktop-info__items">
                    <div class="desktop-info__items-close"></div>';
            if (!empty($product['commentary'])) {
                $html .= '
                <div class="desktop-info__item desktop-info-item">
                    <div class="desktop-info-item__title">
                        <div class="desktop-info-item__title--attention"></div>
                    </div>
                    <div class="desktop-info-item__text desktop-info-item__text--attention">'.$product['commentary'].'</div>
                </div>
                ';
            }
            if ($product['code'] === PriceList::CODE_PRICE_LR_RU) {
                $html .= '
                <div class="desktop-info__item desktop-info-item">
                    <div class="desktop-info-item__title">
                        <div class="desktop-info-item__title--showroom">  </div>
                    </div>
                    <div class="desktop-info-item__text desktop-info-item__text--attention">Товар имеется в шоу-руме LR.RU</div>
                </div>
                ';
            }
            if ($product['quality']) {
                $html .= '
					<div class="desktop-info__item desktop-info-item">
						<div class="desktop-info-item__title">
							'.$product['quality'].'
						</div>
						<div class="desktop-info-item__text">
						</div>
					</div>
                ';
            }
            $html .= '</div>';
            }
            $html .= '</div></div>';
        }
        $html .= '
                    </div>
                </div>
            </article>
        </div>';

        return $html;
    }

    /**
     * @param array $article
     *
     * @return string
     */
    public static function getCardProductDesktopPageHtml(array $article) : string
    {
        $filterHide = $favIcon = '';
        $isFavorite = \common\components\helpers\FavoriteHelper::isFavorite($article['number']);
        if (count($article['products']) <= 1) {
            $filterHide = 'display: none;';
        }
        if ($isFavorite) {
            $favIcon = 'short-options-desktop__favorite-active--on';
        }
        $html = '
        <div class="offers-vendor-catalog-desktop__offer">
            <div class="offer-card-desktop__full full-desktop-card--on">
                <!-- Filter -->
                <div class="full-desktop-card__filter desktop-filter" style="'.$filterHide.'">
                    <p class="desktop-filter__text">Сортировать:</p>
                    <div class="desktop-filter__price offers-desktop-filter-price">
                        по цене
                        <ul class="offers-desktop-filter-price__list">
                            <li class="offers-desktop-filter-price__item">дешевле</li>
                            <li class="offers-desktop-filter-price__item">дороже</li>
                        </ul>
                    </div> 
                    <div class="desktop-filter__delivery-date" style="display: none">по сроку доставки</div>
                    <div class="desktop-filter__close" style="display: none">Скрыть</div>
                </div>  
                    
                <!-- offers-list -->
                <div class="full-desktop-card__list">';
                foreach ($article['products'] as $product) {
                    $delivery_text = '';
                    $delivery_color = '';
                    if (!empty($product['delivery_code'])) {
                        $delivery_data = self::getDeliveryTimeText($product['delivery_code']);
                        $delivery_type = mb_strtolower($delivery_data['delivery']);
                        $delivery_time = mb_strtolower($delivery_data['delivery_time']);
                        if ($delivery_type == $delivery_time) {
                            $delivery_text = $delivery_type;
                        } else {
                            $delivery_text = $delivery_type . ', ' . $delivery_time;
                        }
                        $delivery_text = mb_convert_case($delivery_text, MB_CASE_TITLE, "UTF-8");
                        $delivery_color = $delivery_data['color'];
                    }
                    $stocks = '';
                    if (!empty($product['offers'])) {
                        foreach ($product['offers'] as $name => $color) {
                            $stocks .= Html::tag('div', $name,
                                ['class' => 'desktop-card-item__best-price', 'style' => 'color: ' . $color . ';',]);
                        }
                    }
        
                    $availability = $product['availability'];
                    $isAvailabilityInt = intval($availability) > 0;
                    $replacement = !empty($product['cross_type']) ? '<div class="desktop-properties__replacement" title="'.$product['cross_type'].'">  </div>' : '';
        
                    $priceClass = 'desktop-card-item__price';
                    if (!empty($stocks)) {
                        $priceClass .= ' desktop-card-item__price--best';
                    }
                    if (!is_numeric($product['price'])) {
                        $priceClass = 'desktop-card-item__price--optional';
                    }
                    $html .= '
                        <div class="full-desktop-card__item desktop-card-item">
                            <div class="desktop-card-item__inner">
                                <div class="desktop-card-item__properties desktop-properties">
                                    <div class="desktop-properties__wrapper">
                                        <div class="desktop-properties__manufacturer">' . $product['manufacturer'] . '</div>
                                        <div class="desktop-properties__inner">
                                            <div class="desktop-properties__quality">' . $product['quality'] . '</div>
                                        </div>
                                    </div>
                                    <div class="desktop-properties__icons">
                                        ' . (!empty($product['commentary']) ? '<div class="desktop-properties__icons--attention"></div>' : '') . '
                                        ' . (!empty($product['code']) && $product['code'] === PriceList::CODE_PRICE_LR_RU ? '<div class="desktop-properties__icons--showroom"></div>' : '') . '                                    
                                    </div>
                                </div>
                                <div class="desktop-card-item__price-inner">
                                    <div class="'. $priceClass.'">'.(is_numeric($product['price']) ? self::formatPrice($product['price']) : $product['price']).'</div>
                                    ' . $stocks . '
                                </div>
                                <div class="desktop-card-item__description desktop-description">
                                    <div class="desktop-description__shop">' . ($isAvailabilityInt ? $availability . ' <span>шт</span>' : $availability) . '</div>
                                    <div class="desktop-description__delievery" style="color: '.$delivery_color.';">'.$delivery_text.'</div>
                                </div>
                    ';
                    if (is_numeric($product['price'])) {
                        $html .= '
                        <div class="desktop-card-item__buy desktop-buy">
                            <a href="" class="desktop-buy__fast-buy-btn" data-key="'.$product[PriceList::PRODUCT_KEY].'" data-availability="'.$product['availability'].'"></a>
                            <a href="" class="desktop-buy__buy-btn" data-key="'.$product[PriceList::PRODUCT_KEY].'" data-availability="'.$product['availability'].'"></a>
                        </div>
                        ';
                    }
        
                    $html .= '
                        </div>
                        <div class="desktop-card-item__info desktop-info">
                            <div class="desktop-info__links">
                                <a href="'.Url::to(self::generateProductURLs($article['number'], $product[PriceList::PRODUCT_KEY])).'" class="desktop-info__link" target="_blank">Перейти на страницу товара</a>
                            </div>';
                    if ($product['code'] === PriceList::CODE_PRICE_LR_RU || !empty($product['commentary']) || !empty($product['quality'])) {
                    $html .= '
                        <div class="desktop-info__items">
                            <div class="desktop-info__items-close"></div>';
                    if (!empty($product['commentary'])) {
                        $html .= '
                        <div class="desktop-info__item desktop-info-item">
                            <div class="desktop-info-item__title">
                                <div class="desktop-info-item__title--attention"></div>
                            </div>
                            <div class="desktop-info-item__text desktop-info-item__text--attention">'.$product['commentary'].'</div>
                        </div>
                        ';
                    }
                    if ($product['code'] === PriceList::CODE_PRICE_LR_RU) {
                        $html .= '
                        <div class="desktop-info__item desktop-info-item">
                            <div class="desktop-info-item__title">
                                <div class="desktop-info-item__title--showroom">  </div>
                            </div>
                            <div class="desktop-info-item__text desktop-info-item__text--attention">Товар имеется в шоу-руме LR.RU</div>
                        </div>
                        ';
                    }
                    if ($product['quality']) {
                        $html .= '
                            <div class="desktop-info__item desktop-info-item">
                                <div class="desktop-info-item__title">
                                    '.$product['quality'].'
                                </div>
                                <div class="desktop-info-item__text">
                                </div>
                            </div>
                        ';
                    }
                    $html .= '</div>';
                    }
                    $html .= '</div></div>';
                }

        $html .= '</div>
            </div>
        </div>';

        return $html;
    }

    /**
     * @return array
     */
    public static function getMainShopLevelSettings() : array
    {
        $catalogs = Catalog::find()->where(['level' => Catalog::LEVEL_2,])->orderBy(['order' => SORT_ASC,])->indexBy('code')->asArray()->all();
        $settings = SettingsMainShopLevel::find()->asArray()->indexBy('code')->all();

        foreach ($catalogs as $code => $catalog) {
            $catalogs[$code]['type'] = null;

            if (!empty($settings[$code])) {
                $catalogs[$code]['type'] = $settings[$code]['type'];
            }
        }

        return $catalogs;
    }

    /**
     * @param string $text
     * @param string $number
     * @param string $classBase
     *
     * @return string
     */
    public static function parseCardItemDescription(string $text, string $number, string $classBase) : string {
        $finalVendorUrl = self::generateVendorURLs($number);
        return AppHelper::truncateWords($text, 50, '... '.Html::a('Подробнее', $finalVendorUrl, ['class' => $classBase.'__more', 'style' => 'position: inherit;margin-left: 0;width: auto;height: auto;',]));
    }

    /**
     * @param array $filter
     *
     * @return string
     */
    public static function getFilterDataAttrs(array $filter) : string
    {
        $html = '';

        foreach ($filter as $key => $value) {
            $html .= ' data-filter-'.$key.'="'.$value.'"';
        }

        return $html;
    }

    /**
     * @return array
     */
    public static function analyzeCatalogDepartments() : array
    {
        $departments = Department::find()->where(['is_active' => true,])->andWhere("(catalog_code = '') IS NOT TRUE AND catalog_code IS NOT NULL")->select(['id', 'catalog_code', 'name',])->asArray()->all();
        $catalogDepartments = Catalog::find()->where(['is_department' => true,])->select(['id', 'code', 'name', 'parent_code',])->asArray()->indexBy('code')->all();

        $notFound = $broken =  [];
        // Поиск департаментов в структуре с is_department = true, которых нет в департаментах админки
        foreach ($catalogDepartments as $code => $catalogDepartment) {
            $isFound = false;
            foreach ($departments as $department) {
                if ($department['catalog_code'] === $code) {
                    $isFound = true;
                    break;
                }
            }

            if (!$isFound) {
                $notFound[] = $catalogDepartment;
            }
        }

        // Поиск департаментов в админке, кода у которых нет в каталоге, значит надо переназначить код на правильный департамент из каталога с is_department = true
        foreach ($departments as $department) {
            if (!isset($catalogDepartments[$department['catalog_code']])) {
                $broken[] = $department;
            }
        }

        return ['notFound' => $notFound, 'broken' => $broken,];
    }

    /**
     * @param array $catalogDepartments
     *
     * @return int
     */
    public static function addNewDepartmentsFromCatalog(array $catalogDepartments, bool $isConsole = false) : int
    {
        $savedCount = 0;
//        $maxSort = (int) Department::find()->max('sort');
        foreach ($catalogDepartments as $catalogDepartment) {
            $name = !empty($catalogDepartment['full_name']) ? $catalogDepartment['full_name'] : $catalogDepartment['name'];

            $model = new Department();
            $model->name = $name;
            $model->url = \common\components\helpers\ParserHelper::transliterate($name);
            $model->catalog_code = $catalogDepartment['code'];
            $model->is_active = true;
            $model->sort = self::SORT_DEFAULT;
            if ($model->save()) {
                $savedCount++;

                DepartmentHelper::addDefaultDepartmentMenu($model->id);
            } else {
                ConsoleHelper::debug('Ошибка создания департамента: '.print_r($model->getErrors(), true).print_r($model->attributes, true), $isConsole);
            }
        }

        return $savedCount;
    }

    /**
     * @param        $departments
     * @param        $generationCode
     * @param        $generation
     * @param string $group
     *
     * @return string
     */
    public static function getGenerationUrl($departments, $generationCode, $generation, string $group = '') : string
    {
        if (!empty($generation['link_anchor'])) {
            $url = Url::to(['catalog/view', 'code' => $generation['link_anchor'],]);
        } else {
            if (isset($departments[$generationCode])) {
                $url = Url::to(['shop/shop', 'shop' => $departments[$generationCode]['url'],]);
            } else {
                $url = Url::to(['catalog/view', 'code' => $generationCode,]);
            }

            if (!empty($group)) {
                $url .= '?'.http_build_query(['group' => $group,]);
            }
        }

        return $url;
    }

    /**
     * @param string $shop
     *
     * @return bool
     */
    public static function isGroupDepartment(string $shop) : bool
    {
        $isGroupDepartment = false;
        $groups = CatalogHelper::getCatalogGroupDepartmentsData();
        if ($groups) {
            foreach ($groups as $group) {
                if ($group['url'] === $shop) {
                    $isGroupDepartment = true;

                    break;
                }
            }
        }

        return $isGroupDepartment;
    }

    /**
     * @param string $shop
     * @param bool   $isGroupDepartment
     */
    public static function setDepartmentsViewCookie(string $shop, bool $isGroupDepartment) : void
    {
        $cookieValue = AppHelper::getCookieValue($isGroupDepartment ? CatalogHelper::COOKIE_GROUPS_DEPARTMENTS_VIEW : CatalogHelper::COOKIE_MODELS_DEPARTMENTS_VIEW);

        if (empty($cookieValue)) {
            $departments = [$shop,];
        } else {
            $departments = Json::decode($cookieValue);

            foreach ($departments as $i => $department) {
                if ($department === $shop) {
                    unset($departments[$i]);
                }
            }

            $departments[] = $shop;
        }

        if (count($departments) > self::COOKIE_DEPARTMENTS_VIEW_LIMIT) {
            $departments = array_slice($departments, (count($departments) - self::COOKIE_DEPARTMENTS_VIEW_LIMIT));
        }

        AppHelper::setCookieValue($isGroupDepartment ? CatalogHelper::COOKIE_GROUPS_DEPARTMENTS_VIEW : CatalogHelper::COOKIE_MODELS_DEPARTMENTS_VIEW, Json::encode($departments), (time() + 86400 * 365));
    }

    /**
     * Вернет "Текущий выбор Группы товаров" или "Текущий выбор Модели Авто" как URL департамента или код каталога
     *
     * @param bool $isGroupDepartment
     * @param bool $isCodeReturn
     *
     * @return string
     */
    public static function getLastDepartmentsView(bool $isGroupDepartment, bool $isCodeReturn = false) : string
    {
        $last = '';
        $cookieValue = AppHelper::getCookieValue($isGroupDepartment ? CatalogHelper::COOKIE_GROUPS_DEPARTMENTS_VIEW : CatalogHelper::COOKIE_MODELS_DEPARTMENTS_VIEW);
        $departments = Json::decode($cookieValue);

        if (is_array($departments) && count($departments)) {
            $last = array_pop($departments);
        }

        if ($last && $isCodeReturn) {
            try {
                $department = DepartmentHelper::getDepartmentByUrl($last);

                return $department->catalog_code;
            } catch (NotFoundHttpException $e) {}
        }

        return $last;
    }

    /**
     * @param string $tag
     *
     * @return array
     */
    public static function getDepartmentsTagForLink(string $tag) : array
    {
        $result = [];
        $catalogData = self::getCatalogStructureData();
        $rows = Catalog::find()->select(['code', 'parent_code',])->where(['tag_for_link' => $tag,])->asArray()->indexBy('code')->all();

        if ($rows) {
            foreach ($rows as $code => $row) {
                $result[$code] = [];
                if (!empty($row['is_department'])) {
                    $result[$code] = $row;

                    continue;
                }

                $department = self::getDepartmentForCode($catalogData, $row['parent_code']);
                if ($department) {
                    $result[$code] = $department;
                }
            }

        }

        return $result;
    }

    /**
     * @param array  $catalogData
     * @param string $code
     *
     * @return array
     */
    public static function getDepartmentForCode(array $catalogData, string $code) : array
    {
        if (isset($catalogData[$code])) {
            $row = $catalogData[$code];

            if (!empty($row['is_department'])) {
                return $row;
            } else {
                return self::getDepartmentForCode($catalogData, $row['parent_code']);
            }
        } else {
            return [];
        }
    }

    /**
     * @param array  $catalogItem
     * @param array  $catalogLinktagDepartmentData
     * @param string $lastDepartmentViewCode
     * @param string $lastDepartmentViewTitle
     * @param array  $linkTags
     *
     * @return string
     */
    public static function getCatalogRubricName(array $catalogItem, array $catalogLinktagDepartmentData, string $lastDepartmentViewCode, string $lastDepartmentViewTitle, array $linkTags) : string
    {
        $name = '';

        if (!empty($catalogItem['link_tag'])) {
            if (!empty($catalogItem['title'])) {
                $name .= $catalogItem['title'];
            } else {
                $words = explode(' ', $catalogItem['name']);
                switch (count($words)) {
                    case 1:
                    case 2:
                        $name .= $words[0];
                        break;
                    case 3:
                        $name .= $words[0].' '.$words[1];
                        break;
                    case 4:
                        $name .= $words[0].' '.$words[1].' '.$words[2];
                        break;
                    default:
                        $name .= $catalogItem['name'];
                        break;
                }
            }

            //  У пользователя установлен выбор уровня:  Марка - Модель - Поколение (Департамент)
            if (!empty($lastDepartmentViewCode)) {
                if (!empty($catalogLinktagDepartmentData[$catalogItem['link_tag']])) {
                    $isHasModelLinkTag = false;
                    foreach ($catalogLinktagDepartmentData[$catalogItem['link_tag']] as $catalogCode => $departmentData) {
                        //  для выбранной модели есть Раздел-цель
                        if ($departmentData['department_code'] === $lastDepartmentViewCode) {
                            $isHasModelLinkTag = true;
                            $dataLink = Url::to(['catalog/view', 'code' => $catalogCode,]);

                            if (!empty($departmentData['department_url'])) {
                                $dataLink = Url::to(['shop/shop', 'shop' => $departmentData['department_url'], 'menu' => $catalogCode,]);
                            }

                            $name .= ' для '. $lastDepartmentViewTitle;
                            $name .= ' '.Html::tag('div', '', ['class' => 'shop-catalog-desktop__tag-link--forward', 'data-link' => $dataLink,]);
                            break;
                        }
                    }

                    // для выбранной модели НЕТ Раздела-цели
                    if (!$isHasModelLinkTag) {
                        $name = Html::beginTag('div', ['class' => 'shop-catalog-desktop__tag-link--model-no-offers',]);
                        $name .= Html::beginTag('div', ['class' => 'shop-catalog-desktop__tag-link-description',]);
                        $name .= Html::tag('div', $catalogItem['name'], ['class' => 'shop-catalog-desktop__tag-link-text',]);
                        $name .= Html::beginTag('div', ['class' => 'shop-catalog-desktop__tag-link-info-wrapper',]);
                        $name .= Html::tag('div', 'Для выбранной модели', ['class' => 'shop-catalog-desktop__tag-link-info',]);
                        $name .= Html::tag('div', $lastDepartmentViewTitle, ['class' => 'shop-catalog-desktop__tag-link-info--model',]);
                        $name .= Html::tag('div', Html::tag('span', 'Нет предложений'), ['class' => 'shop-catalog-desktop__tag-link-info',]);
                        $name .= Html::endTag('div');
                        $name .= Html::tag('div', 'Посмотреть все модели', ['class' => 'shop-catalog-desktop__tag-link-btn', 'data-link' => Url::to(['catalog/models', 'group' => $catalogItem['code'],]),]);
                        $name .= Html::endTag('div');
                        $name .= Html::endTag('div');
                    }
                }

//                if ($catalogItem['code'] === 'KAT0011488') {
//                    $name .= '<!--';
//                    $name .= print_r($catalogItem, 1).PHP_EOL;
//                    $name .= '=================================='.PHP_EOL;
//                    $name .= print_r($catalogLinktagDepartmentData, 1);
//                    $name .= '-->';
//                }
            } else { //У пользователя  НЕ установлен выбор уровня:  Марка - Модель - Поколение (Департамент)
                $name = Html::beginTag('div', ['class' => 'shop-catalog-desktop__tag-link--no-model',]);
                $name .= Html::beginTag('div', ['class' => 'shop-catalog-desktop__tag-link-description',]);
                    $name .= Html::tag('div', $catalogItem['name'], ['class' => 'shop-catalog-desktop__tag-link-text',]);
                    $name .= Html::beginTag('div', ['class' => 'shop-catalog-desktop__tag-link-info-wrapper',]);
                        $name .= Html::tag('div', 'Модель автомобиля не выбрана', ['class' => 'shop-catalog-desktop__tag-link-info',]);
                    $name .= Html::endTag('div');
                    $name .= Html::tag('div', 'Посмотреть все модели', ['class' => 'shop-catalog-desktop__tag-link-btn', 'data-link' => Url::to(['catalog/models', 'group' => $catalogItem['code'],]),]);
                $name .= Html::endTag('div');
                $name .= Html::endTag('div');
            }
        } else {
            $name = $catalogItem['name'];

            if (!empty($catalogItem['link_anchor'])) {
                $link = Url::to(['catalog/view', 'code' => $catalogItem['link_anchor'],]);
                $name .= ' '.Html::tag('div', '', ['class' => 'shop-catalog-desktop__tag-link--backward', 'data-link' => $link,]);
            }
        }

        if (!empty($catalogItem[Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT])) {
            $name .= ' '.Html::tag('div', $catalogItem[Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT], ['class' => 'shop-catalog-desktop__tag-link--counter',]);
        }

        return $name;
    }

    /**
     * @return array
     */
    public static function getCatalogLinktagDepartmentData() : array
    {
        $cache = \Yii::$app->cache;
        $key = self::CACHE_CATALOG_LINKTAG_DEPARTMENT;
//        $cache->delete($key);

        return $cache->getOrSet($key, function () {
            $data = [];

            $query = CatalogLinktagDepartment::find();
            $query->select(CatalogLinktagDepartment::tableName().'.*')->addSelect(Department::tableName().'.url as department_url');
            $query->leftJoin(Department::tableName(), CatalogLinktagDepartment::tableName().'.department_code = '.Department::tableName().'.catalog_code');
            $query->asArray();

            $rows = $query->all();
            foreach ($rows as $row) {
                $data[$row['link_tag']][$row['code']] = [
                    'department_code' => $row['department_code'],
                    'department_url' => $row['department_url'],
                ];
            }

            return $data;
        }, 3600 * 24 * 30);
    }

    /**
     * Заполнение таблицы CatalogLinktagDepartment для упрощения работы с каталогом по полям link_tag и tag_for_link
     *
     * @return int
     * @throws \yii\db\Exception
     */
    public static function fillCatalogLinktagDepartment() : int
    {
        $count = 0;
        $t = time();
        $data = [];
        (new Query())->createCommand()->truncateTable(CatalogLinktagDepartment::tableName())->execute();

        $cache = \Yii::$app->cache;
        $key = CatalogHelper::CACHE_CATALOG_LINKTAG_DEPARTMENT;
        if ($cache->exists($key)) {
            $cache->delete($key);
        }

        $catalogData = CatalogHelper::getCatalogStructureData();
        $tagForLinkRows = Catalog::find()->where(['is_product' => Catalog::IS_PRODUCT_NO,])->andWhere("(tag_for_link = '') IS NOT TRUE AND tag_for_link IS NOT NULL")->asArray()->all();

        foreach ($tagForLinkRows as $tagForLinkRow) {
            if (empty($tagForLinkRow['is_department'])) {
                $department = CatalogHelper::getDepartmentForCode($catalogData, $tagForLinkRow['parent_code']);
            } else {
                $department = $tagForLinkRow;
            }

            if (!empty($department)) {
                $data[] = [
                    'link_tag' => $tagForLinkRow['tag_for_link'],
                    'code' => $tagForLinkRow['code'],
                    'department_code' => $department['code'],
                    'created_at' => $t,
                    'updated_at' => $t,
                ];
            }
        }

        if ($data) {
            $count = (new Query())->createCommand()->batchInsert(CatalogLinktagDepartment::tableName(), ['link_tag', 'code', 'department_code', 'created_at', 'updated_at',], $data)->execute();
        }

        return $count;
    }

    /**
     * @param array  $trees
     * @param string $linkTag
     *
     * @return array
     */
    public static function calculateTagForLink(array &$trees, string $linkTag) : array
    {
        $codes = [];
        $structureData = self::getCatalogStructureData();

        foreach ($structureData as $code => $row) {
            if ($row['tag_for_link'] === $linkTag) {
                self::_calculateTagForLink2($structureData, $codes, $row, true);
            }
        }

        foreach ($trees as $typeCode => $tree) {
            // 1 level
            if (isset($codes[$tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT]['code']])) {
                $trees[$typeCode][Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT][Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT] = $codes[$tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_PARENT]['code']];
            }
            foreach ($tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN] as $modelCode => $model) {
                if (isset($codes[$modelCode])) {
                    $trees[$typeCode][Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN][$modelCode][Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT] = $codes[$modelCode];
                }
            }

            // 2-4 levels
            $levels = [Catalog::TREE_LEVEL_SECOND, Catalog::TREE_LEVEL_THIRD, Catalog::TREE_LEVEL_FOURTH,];
            foreach ($levels as $level) {
                foreach ($tree[$level] as $brandCode => $modelData) {
                    if (isset($codes[$modelData[Catalog::TREE_ITEM_PARENT]['code']])) {
                        $trees[$typeCode][$level][$brandCode][Catalog::TREE_ITEM_PARENT][Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT] = $codes[$modelData[Catalog::TREE_ITEM_PARENT]['code']];
                    }

                    foreach ($modelData[Catalog::TREE_ITEM_CHILDREN] as $modelCode => $model) {
                        if (isset($codes[$modelCode])) {
                            $trees[$typeCode][$level][$brandCode][Catalog::TREE_ITEM_CHILDREN][$modelCode][Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT] = $codes[$modelCode];
                        }
                    }
                }
            }
        }

        return $trees;
    }

    /**
     * @param array $structureData
     * @param array $codes
     * @param array $row
     *
     * @return array
     */
    public static function _calculateTagForLink(array $structureData, array &$codes, array $row) : array
    {
        $code = $row['code'];
        if (!isset($codes[$code])) {
            $codes[$code] = 0;
        }

        $codes[$code] += 1;

        if (!empty($row['parent_code'])) {
            $parentRow = $structureData[$row['parent_code']];

            return self::_calculateTagForLink($structureData, $codes, $parentRow);
        }

        return $codes;
    }

    /**
     * @param array $structureData
     * @param array $codes
     * @param array $row
     * @param bool  $isLast
     *
     * @return array
     */
    public static function _calculateTagForLink2(array $structureData, array &$codes, array $row, bool $isLast = false) : array
    {
        $code = $row['code'];
        if (!isset($codes[$code])) {
            $codes[$code] = 0;
        }

        if ($isLast) {
            $count = Catalog::find()->where(['parent_code' => $code, 'is_product' => Catalog::IS_PRODUCT_YES,])->count();
        } else {
            $count = $row['count'];
        }

        $codes[$code] += $count;

        if (!empty($row['parent_code'])) {
            $parentRow = $structureData[$row['parent_code']];
            $parentRow['count'] = $count;

            return self::_calculateTagForLink2($structureData, $codes, $parentRow, false);
        }

        return $codes;
    }

    /**
     * @param string $groupTitle
     * @param array  $row
     * @param string $type
     *
     * @return string
     */
    public static function renderTagForLinkCounter(string $groupTitle, array $row, string $type) : string
    {
        $counter = '';

        if (!empty($groupTitle) && !empty($row[Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT])) {
            switch ($type) {
                case self::COUNTER_TYPE_TYPE:
                    $counter = Html::tag('span', $row[Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT]);
                    break;
                case self::COUNTER_TYPE_MODEL:
                    $counter = Html::tag('span', $row[Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT], ['class' => 'model-auto__brand-item-counter',]);
                    break;
                case self::COUNTER_TYPE_GENERATION:
                    $counter = Html::tag('span', $row[Catalog::TREE_ITEM_CHILDREN_GROUP_COUNT], ['class' => 'shop-catalog-desktop__tag-link--counter',]);
                    break;
            }
        }

        return  $counter;
    }

    /**
     * @param array  $tree
     * @param string $code
     *
     * @return array
     */
    public static function getRubricTitles(array $tree, string $code) : array
    {
        $rubricTitles = [];
        $lastDepartmentViewCode = $lastDepartmentViewTitle = '';

        $linkTags = Catalog::find()->where(['is_product' => Catalog::IS_PRODUCT_NO,])->andWhere("(link_tag = '') IS NOT TRUE AND link_tag IS NOT NULL")->indexBy('link_tag')->asArray()->all();
        $departments = Department::find()->where(['is_active' => true,])->andWhere("(catalog_code = '') IS NOT TRUE AND catalog_code IS NOT NULL")->indexBy('catalog_code')->asArray()->all();
        $catalogData = CatalogHelper::getCatalogStructureData();
        $catalogLinktagDepartmentData = CatalogHelper::getCatalogLinktagDepartmentData();

        if (isset($catalogData[$code])) {
            $shop = $departmentCode = '';
            $catalogItem = $catalogData[$code];
            if (!empty($catalogItem['is_department'])) {
                $departmentCode = $catalogItem['code'];
            } else {
                $catalogItem = CatalogHelper::getDepartmentForCode($catalogData, $catalogItem['parent_code']);
                if ($catalogItem) {
                    $departmentCode = $catalogItem['code'];
                }
            }

            if ($departmentCode) {
                $department = isset($departments[$departmentCode]) ? $departments[$departmentCode] : [];
                if ($department) {
                    $shop = $department['url'];
                }
            }

            if ($shop) {
                $isGroupDepartment = CatalogHelper::isGroupDepartment($shop);
                $lastDepartmentViewCode = CatalogHelper::getLastDepartmentsView(!$isGroupDepartment, true);

                if ($lastDepartmentViewCode) {
                    $lastDepartmentViewTitle = isset($catalogData[$lastDepartmentViewCode]) ? $catalogData[$lastDepartmentViewCode]['name'] : '';
                }
            }
        }

        // Имена для рубрик
        if (!empty($tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN])) {
            foreach ($tree[Catalog::TREE_LEVEL_FIRST][Catalog::TREE_ITEM_CHILDREN] as $childrenCode => $children) {
                $rubricTitles[$childrenCode] = [
                    'title' => CatalogHelper::getCatalogRubricName($children, $catalogLinktagDepartmentData, $lastDepartmentViewCode, $lastDepartmentViewTitle, $linkTags),
                ];
            }
        }

        $levels = [Catalog::TREE_LEVEL_SECOND, Catalog::TREE_LEVEL_THIRD, Catalog::TREE_LEVEL_FOURTH,];
        foreach ($levels as $level) {
            if (!empty($tree[$level])) {
                foreach ($tree[$level] as $brandCode => $modelData) {
                    if (!empty($modelData[Catalog::TREE_ITEM_CHILDREN])) {
                        foreach ($modelData[Catalog::TREE_ITEM_CHILDREN] as $childrenCode => $children) {
                            $rubricTitles[$childrenCode] = [
                                'title' => CatalogHelper::getCatalogRubricName($children, $catalogLinktagDepartmentData, $lastDepartmentViewCode, $lastDepartmentViewTitle, $linkTags),
                            ];
                        }
                    }
                }
            }
        }

        return $rubricTitles;
    }
}