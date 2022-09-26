<?php
namespace common\components\helpers;


use common\models\Articles;
use common\models\Favorite;
use common\models\FullPrice;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use common\components\helpers\CatalogHelper;
use yii\web\NotFoundHttpException;
use common\models\SpecialOffers;
use common\models\PriceList;
use common\models\ReclamaStatus;
use yii\db\Expression;
use yii\db\Query;

class FavoriteHelper
{
    const COOKIE_FAVORITE_GUEST = 'favorite_guest';

    /**
     * @param string $number
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    public static function add(string $number) : bool
    {
        $result = false;

        $articleModel = CatalogHelper::getArticleModelByNumber($number);

        if (!$articleModel) {
            throw new NotFoundHttpException('Артикул не найден по номеру: '.$number);
        }

        if (!Yii::$app->user->isGuest) {
            if (!Favorite::find()->where(['user_id' => Yii::$app->user->id, 'articles_number' => $articleModel->number,])->exists()) {
                $model = new Favorite();
                $model->user_id = Yii::$app->user->id;
                $model->articles_number = $articleModel->number;
                $model->articles_id = $articleModel->id;

                $result = $model->save();
            }
        } else { //Гость
            $cookieValue = AppHelper::getCookieValue(self::COOKIE_FAVORITE_GUEST);

            if (empty($cookieValue)) {
                $list = [$number,];
            } else {
                $list = Json::decode($cookieValue);
                if (!in_array($number, $list)) {
                    $list[] = $number;
                }
            }

            AppHelper::setCookieValue(self::COOKIE_FAVORITE_GUEST, Json::encode($list));

            $result = true;
        }

        return $result;
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public static function list() : array
    {
        $result = [];

        $cookieValue = AppHelper::getCookieValue(self::COOKIE_FAVORITE_GUEST);
        if (!Yii::$app->user->isGuest) {
            $cookieList = [];
            if (!empty($cookieValue)) {
                $cookieList = Json::decode($cookieValue);
            }

            if (!empty($cookieList)) {
                foreach ($cookieList as $key) {
                    self::add($key);
                }

                AppHelper::deleteCookie(self::COOKIE_FAVORITE_GUEST);
            }

            $result = Favorite::find()->select(['articles_number',])->where(['user_id' => Yii::$app->user->id,])->orderBy(['created_at' => SORT_DESC,])->column();
        } else {
            if (!empty($cookieValue)) {
                $result = Json::decode($cookieValue);
            }
        }

        return $result;
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public static function emailArticlesData() : array
    {
        $data = [];

        $cookieModelsList = self::list();
        $query = Articles::find()->select([
            Articles::tableName().'.number',
            Articles::tableName().'.name',
            Articles::tableName().'.description',
            Articles::tableName().'.is_in_stock',
        ]);
        $query->andWhere(['number' => $cookieModelsList]);
        //$query->andWhere(['is_in_stock' => true]);
            
        $query->asArray(true);

        $subQuery = (new Query())
            ->select([
                new Expression("string_agg(offer_name, ';')"),
            ])
            ->from(SpecialOffers::tableName())
            ->where(SpecialOffers::tableName().'.article_number = '.Articles::tableName().'.number AND '.SpecialOffers::tableName().'.offer_type = :flag', [':flag' => SpecialOffers::OFFER_TYPE_FLAG,])
            ->limit(2);
        $query->addSelect(['offers' => $subQuery,]);

        $subQuery = (new Query())
            ->select([
                new Expression("string_agg(price, ';')"),
            ])
            ->from(PriceList::tableName())
            ->where(PriceList::tableName().'.article_number = '.Articles::tableName().'.number');
        $query->addSelect(['prices' => $subQuery,]);
        
        foreach ($query->all() as $article) {
            $list = [];
            if (!empty($article['is_in_stock'])) {
                $list[ReclamaStatus::IN_STOCK] = ReclamaStatus::IN_STOCK_COLOR;
            }

            if (!empty($article['offers'])) {
                $offers = explode(';', $article['offers']);
                foreach ($offers as $offer) {
                    $list[$offer] = isset($specialOfferColors[$offer]) ? $specialOfferColors[$offer] : ReclamaStatus::DEFAULT_COLOR;
                }
            }

            $article['offers'] = $list;

            $article['price'] = 0;
            if (!empty($article['prices'])) {
                $prices = explode(';', $article['prices']);
                foreach ($prices as $i => $price) {
                    if (!is_numeric($price)) {
                        unset($prices[$i]);
                    }
                }

                if ($prices) {
                    $article['price'] = min($prices);
                }

                unset($article['prices']);
            }

            $article['image'] = '';
            $images = CatalogHelper::scanCatalogImages($article['number']);
            if ($images) {
                $article['image'] = array_shift($images);
            }

            $data[$article['number']] = $article;
        }
        
        return $data;
    }

    /**
     * @param string $number
     *
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function delete(string $number) : bool
    {
        $result = false;

        if (!Yii::$app->user->isGuest) {
            $model = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'articles_number' => $number,])->one();

            if ($model && $model->delete()) {
                $result = true;
            }
        } else { //Гость
            $cookieValue = AppHelper::getCookieValue(self::COOKIE_FAVORITE_GUEST);

            if (!empty($cookieValue)) {
                $list = Json::decode($cookieValue);

                foreach ($list as $i => $value) {
                    if ($number === $value) {
                        unset($list[$i]);
                        $result = true;

                        break;
                    }
                }

                if (!empty($list)) {
                    AppHelper::setCookieValue(self::COOKIE_FAVORITE_GUEST, Json::encode($list));
                } else {
                    AppHelper::deleteCookie(self::COOKIE_FAVORITE_GUEST);
                }
            }
        }

        return $result;
    }

    /**
     * @return bool
     */
    public static function clear() : bool
    {
        AppHelper::deleteCookie(self::COOKIE_FAVORITE_GUEST);

        if (!Yii::$app->user->isGuest) {
            Favorite::deleteAll(['user_id' => Yii::$app->user->id,]);
        }

        return true;
    }

    /**
     * @param string $number
     *
     * @return bool
     */
    public static function isFavorite(string $number) : bool
    {
        $rows = [];
        $cookieValue = AppHelper::getCookieValue(self::COOKIE_FAVORITE_GUEST);

        if (!empty($cookieValue)) {
            $rows = Json::decode($cookieValue);
        }

        if (!Yii::$app->user->isGuest) {
            $dbRows = Favorite::find()->select(['articles_number',])->where(['user_id' => Yii::$app->user->id,])->orderBy(['created_at' => SORT_DESC,])->column();

            if ($dbRows) {
                $rows = array_merge($rows, $dbRows);
            }
        }

        if ($rows) {
            $rows = array_unique($rows);
            $rows = array_flip($rows);
        }

        return isset($rows[$number]);
    }
}