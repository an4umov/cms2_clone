<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\models\Articles;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\SpecialOffers;
use yii\base\Widget;
use yii\data\Pagination;
use yii\db\Expression;
use yii\db\Query;

// Блок товарных предложений
class ProductOffersWidget extends Widget
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

    public function init()
    {
        parent::init();

        if (is_null($this->title)) {
            $this->title = 'Товарные предложения';
        }
        if (is_null($this->limit)) {
            $this->limit = self::LIMIT;
        }
        if (is_null($this->numbers)) {
            $this->numbers = [];
        }
        if (is_null($this->filter)) {
            $this->filter = [];
        }
        if (is_null($this->shop)) {
            $this->shop = DepartmentMenuWidget::ACTIVE_SHOP_ALL;
        }
        if (is_null($this->isPage)) {
            $this->isPage = false;
        }
    }

    public function run()
    {
        $data = $data_noprice = $orderBy = [];
        $specialOfferColors = [];
        foreach (ReclamaStatus::find()->asArray()->all() as $row) {
            $specialOfferColors[$row['name']] = $row['color'] ?: ReclamaStatus::DEFAULT_COLOR;
        }

        $filter = [self::PARAM_NUMBER => $this->number, self::PARAM_NUMBERS => $this->numbers, self::PARAM_TEXT => $this->text, self::PARAM_SHOP => $this->shop, self::PARAM_FILTER => $this->filter,];

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
        $query->addSelect(['prices' => $subQuery,])->orderBy('prices');

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
            $query = PriceList::find()->select(['manufacturer', 'quality', 'cross_type', 'commentary', 'code', 'price', 'availability', 'delivery_code', PriceList::PRODUCT_KEY,])->where([PriceList::tableName().'.article_number' => $article['number'],])->asArray();
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

            $title_noprice = '';
            if ($article['price'] == 0) {
                $title_noprice = 'Товарные предложения не в наличии';
            }
        }
        if(count($data) > 0 || count($data_noprice) > 0) {
            return $this->render('product_offers', [
                self::PARAM_TITLE => $this->title,
                'data' => $data,
                //'data_noprice' => $data_noprice,
                'title_noprice' => $title_noprice,
                'isPage' => $this->isPage,
                'number' => $this->number,
                'pagination' => $pagination,
            ]);
        } else {
            return $this->render('error', [
                'text' => 'К сожалению ничего не найдено'
            ]);
        }

    }
}
