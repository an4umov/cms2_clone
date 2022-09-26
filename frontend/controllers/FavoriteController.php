<?php

namespace frontend\controllers;

use common\components\helpers\AppHelper;
use common\components\helpers\FavoriteHelper;
use common\models\Order;
use common\models\OrderItem;
use \Yii;
use common\components\helpers\CatalogHelper;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\Articles;
use common\models\SpecialOffers;
use common\models\FavoriteForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\Url;

class FavoriteController extends Controller
{
    const LIMIT = 10;

    const PARAM_NUMBER = 'number';
    const PARAM_NUMBERS = 'numbers';
    const PARAM_TEXT = 'text';
    const PARAM_SHOP = 'shop';
    const PARAM_LIMIT = 'limit';
    const PARAM_TITLE = 'title';
    const PARAM_FILTER = 'filter';

    public $title;
    public $text;
    public $number;
    public $numbers;
    public $limit;
    public $offset;
    public $shop;
    public $isPage;
    public $filter;
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET', 'POST'],
                    'add' => ['POST',],
                    'remove' => ['POST',],
                    'clear' => ['POST', 'GET',],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $data = $orderBy = [];
        $specialOfferColors = [];

        $cookieModelsList = FavoriteHelper::list();

        foreach (ReclamaStatus::find()->asArray()->all() as $row) {
            $specialOfferColors[$row['name']] = $row['color'] ?: ReclamaStatus::DEFAULT_COLOR;
        }
        
        $filter = [self::PARAM_NUMBER => $cookieModelsList, self::PARAM_NUMBERS => $this->numbers, self::PARAM_TEXT => $this->text, self::PARAM_SHOP => $this->shop, self::PARAM_FILTER => $this->filter,];

        $query = Articles::find()->select([
            Articles::tableName().'.number',
            Articles::tableName().'.name',
            Articles::tableName().'.description',
            Articles::tableName().'.is_in_stock',
        ]);

        if (!empty($filter[self::PARAM_TEXT])) {
            if (!empty($filter[self::PARAM_NUMBER])) {
                $query->andWhere(['or', ['ilike', Articles::tableName().'.name', $filter[self::PARAM_TEXT],], ['ilike', Articles::tableName().'.number', $filter[self::PARAM_NUMBER],],]);
            } elseif (!empty($filter[self::PARAM_NUMBERS]) && is_array($filter[self::PARAM_NUMBERS])) {
                $query->andWhere(['or', ['ilike', Articles::tableName().'.name', $filter[self::PARAM_TEXT],], ['in', Articles::tableName().'.number', $filter[self::PARAM_NUMBERS],],]);

                foreach ($filter[self::PARAM_NUMBERS] as $number) {
                    $orderBy[] = '"articles"."number"='."'".$number."' DESC";
                }
            } else {
                $query->andWhere(['ilike', Articles::tableName().'.name', $filter[self::PARAM_TEXT],]);
            }
        } else {
            if (!empty($filter[self::PARAM_NUMBER])) {
                $query->andWhere([Articles::tableName().'.number' => $filter[self::PARAM_NUMBER],]);
            } elseif (!empty($filter[self::PARAM_NUMBERS]) && is_array($filter[self::PARAM_NUMBERS])) {
                $query->andWhere(['in', Articles::tableName() . '.number', $filter[self::PARAM_NUMBERS],]);

                foreach ($filter[self::PARAM_NUMBERS] as $number) {
                    $orderBy[] = '"articles"."number"='."'".$number."' DESC";
                }
            } else {
                $query->where('0 = 1');
            }
        }

        if (!empty($filter[self::PARAM_FILTER])) {
            if (!empty($filter[self::PARAM_FILTER]['isStock'])) {
                $query->andWhere([Articles::tableName().'.is_in_stock', true,]);
            }
        }

        $pagination = new Pagination([
            'defaultPageSize' => self::LIMIT,
            'totalCount' => $query->count(),
        ]);

        $query->limit($pagination->limit);
        $query->offset($pagination->offset);
        $query->asArray(true);
        if ($orderBy) {
            $query->orderBy(join(', ', $orderBy));
        }

        //shop
        /* что то сделать для активного департамента, shop */

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

            $article['products'] = [];
            $query = PriceList::find()->select(['manufacturer', 'quality', 'cross_type', 'commentary', 'code', 'price', 'availability', PriceList::PRODUCT_KEY,])->where([PriceList::tableName().'.article_number' => $article['number'],])->asArray();
            $subQuery = (new Query())
                ->select('offer_name')
                ->from(SpecialOffers::tableName())
                ->where(SpecialOffers::tableName().'.article_number = '.PriceList::tableName().'.article_number AND '.SpecialOffers::tableName().'.offer_type = :flag', [':flag' => SpecialOffers::OFFER_TYPE_FLAG,])
                ->limit(1);
            $query->addSelect(['offers' => $subQuery,]);

            foreach ($query->all() as $product) {
                if (!empty($product['offers'])) {
                    $list = [];
                    $list[$product['offers']] = isset($specialOfferColors[$product['offers']]) ? $specialOfferColors[$product['offers']] : ReclamaStatus::DEFAULT_COLOR;

                    $product['offers'] = $list;
                }

                $article['products'][] = $product;
            }

            $data[$article['number']] = $article;
        }
        $favoriteForm = new favoriteForm();
        return $this->render('index', [
            'data' => $data,
            self::PARAM_TITLE => 'Избранное',
            'isPage' => $this->isPage,
            'number' => $this->number,
            'pagination' => $pagination,
            'favoriteForm' => $favoriteForm
        ]);
    }

    /**
     * @return array
     */
    public function actionAdd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['ok' => false,];

        $number = Yii::$app->request->post('key');
        if (empty($number)) {
            $response['message'] = 'Не указан обязательный параметр';

            return $response;
        }

        try {
            $result = FavoriteHelper::add($number);

            $response['ok'] = $result;
            $response['count'] = count(FavoriteHelper::list());
            if (!$result) {
                $response['message'] = 'Ошибка добавления в избранное';
            }
        } catch (NotFoundHttpException $e) {
            Yii::$app->errorHandler->logException($e);
            $response['message'] = $e->getMessage();
        }

        return $response;
    }


    /**
     * @return array
     * @throws \Throwable
     */
    public function actionRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['ok' => false,];

        $number = Yii::$app->request->post('key');
        if (empty($number)) {
            $response['message'] = 'Не указан обязательный параметр';

            return $response;
        }

        try {
            $result = FavoriteHelper::delete($number);

            $response['ok'] = $result;
            $response['count'] = count(FavoriteHelper::list());
            if (!$result) {
                $response['message'] = 'Ошибка удаления из избранного';
            }
        } catch (\Exception $e) {
            Yii::$app->errorHandler->logException($e);
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    /**
     * @return \yii\console\Response|Response
     */
    public function actionClear()
    {
//        Yii::$app->response->format = Response::FORMAT_JSON;

        FavoriteHelper::clear();

//        return ['ok' => FavoriteHelper::clear(),];
        return $this->redirect('/favorite');
    }
    public function actionSend()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['ok' => false,];
        
        $favoriteForm = new favoriteForm();
        $favoriteForm->email = Yii::$app->request->getBodyParam('email');
        $setFrom = $_SERVER['HTTP_HOST'];
        $cookieModelsList = FavoriteHelper::list();
        $data = FavoriteHelper::emailArticlesData();
        if (empty($favoriteForm->email)) {
            Yii::$app->response->statusCode = 100;
            $response['ok'] = false;
            $response['message'] = 'Укажите правильный e-mail адрес!';
            return $response;
        }

        try {
            \Yii::$app->mailer
            ->compose('favorite-email', ['cookieModelsList' => $cookieModelsList, 'data' => $data])
            ->setFrom(['no-reply@'.$setFrom => 'Избранное с сайта lr.ru'])
            ->setTo($favoriteForm->email)
            ->setSubject('Список избранного')
            //->setTextBody('Plain text content')
            //->setHtmlBody('123123')
            ->send();
            Yii::$app->response->statusCode = 200;
            $response['ok'] = true;
            $response['message'] = 'Список избранного был отправлен Вам на почту ('.$favoriteForm->email.')';

            if (!$response['ok']) {
                Yii::$app->response->statusCode = 100;
                $response['message'] = 'Ошибка';
            }
        } catch (\Exception $e) {
            Yii::$app->errorHandler->logException($e);
            $response['message'] = $e->getMessage();
        }

        return $response;
    }
}