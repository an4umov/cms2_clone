<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\models\Articles;
use common\models\Catalog;
use common\models\FullPrice;
use frontend\models\search\ArticleItemSearch;
use frontend\models\search\CatalogListSearch;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ArticleItemsWidget extends Widget
{
    const SORT_PRICE_ASC = 'price_asc';
    const SORT_PRICE_DESC = 'price_desc';
    const SORT_LIST = [self::SORT_PRICE_ASC, self::SORT_PRICE_DESC,];

    const FILTER_ALL = 'all';
    const FILTER_STOCK = 'stock'; //Только в наличии на складе
    const FILTER_QUICK = 'quick'; //Наличие и быстрый заказ
    const FILTER_LIST = [self::FILTER_ALL, self::FILTER_STOCK, self::FILTER_QUICK,];

    /** @var string */
    public $sort;

    /** @var string */
    public $filter;

    /** @var bool */
    public $isCatalogList = false;

    /** @var int */
    public $index;

    /**
     * @var Articles
     */
    public $model;

    /** @var string */
    public $id = 'article-items-list';

    public function init()
    {
        parent::init();

        if (empty($this->model)) {
            throw new NotFoundHttpException('Отсутствует модель артикула');
        }

        $this->sort = self::SORT_PRICE_ASC;
        $this->filter = self::FILTER_ALL;
    }

    public function run()
    {
        $searchModel = new ArticleItemSearch();

        $params = Yii::$app->request->post();
        if (empty($params['sort'])) {
            $params['sort'] = $this->sort;
        }
        if (empty($params['filter'])) {
            $params['filter'] = $this->filter;
        }

        $dataProvider = $searchModel
            ->setArticle($this->model)
            ->search($params);

        $isInCart = false;
        $data = [FullPrice::GROUP_PRICE_LIST_DEFAULT => ['color' => '', 'list' => [],],];
        /** @var FullPrice $model */
        /**
        foreach ($dataProvider->getModels() as $model) {
            if (!$isInCart && $model->isInCart()) {
                $isInCart = true;
            }

            if (empty($model->group_price_list)) {
                $data[FullPrice::GROUP_PRICE_LIST_DEFAULT]['color'] = $model->group_price_list_color;
                $data[FullPrice::GROUP_PRICE_LIST_DEFAULT]['list'][] = $model;
            } else {
                $data[$model->group_price_list]['color'] = $model->group_price_list_color;
                $data[$model->group_price_list]['list'][] = $model;
            }
        }*/

        return $this->render('article_item_list', [
            'data' => $data,
            'searchModel' => $searchModel,
            'model' => $this->model,
            'isCatalogList' => $this->isCatalogList,
            'index' => $this->index,
            'isInCart' => $isInCart,
        ]);
    }
}
