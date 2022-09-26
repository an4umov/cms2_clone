<?php

namespace frontend\models\search;

use common\models\Articles;
use common\models\FullPrice;
use common\models\PriceList;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ArticleItemSearch extends \yii\base\Model
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

    /**
     * @var Articles
     */
    public $article;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sort', 'in', 'range' => self::SORT_LIST,],
            ['filter', 'in', 'range' => self::FILTER_LIST,],
        ];
    }

    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     * @throws NotFoundHttpException
     */
    public function search(array $params) : ActiveDataProvider
    {
        $this->load($params);

        if (empty($this->article)) {
            throw new NotFoundHttpException('Отсутствует модель артикула');
        }

        $query = PriceList::find()
            ->where([
                PriceList::tableName() . '.article_number' => $this->article->number,
            ]);

        switch ($this->filter) {
            case self::FILTER_STOCK:
                break;
            case self::FILTER_QUICK:
                break;
        }

        switch ($this->sort) {
            case self::SORT_PRICE_ASC:
                $query->orderBy(['price' => SORT_ASC,]);
                break;
            case self::SORT_PRICE_DESC:
                $query->orderBy(['price' => SORT_DESC,]);
                break;
        }

        // add conditions that should always apply here
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);
    }

    /**
     * @param Articles $article
     *
     * @return ArticleItemSearch
     */
    public function setArticle(Articles $article): ArticleItemSearch
    {
        $this->article = $article;

        return $this;
    }

    /**
     * @return array
     */
    public function getSortOptions() : array
    {
        return [
            self::SORT_PRICE_ASC => 'По цене (возрастание)',
            self::SORT_PRICE_DESC => 'По цене (убывание)',
        ];
    }

    /**
     * @return array
     */
    public function getFilterOptions() : array
    {
        return [
            self::FILTER_ALL => 'Все',
            self::FILTER_STOCK => 'Только в наличии на складе',
            self::FILTER_QUICK => 'Наличие и быстрый заказ',
        ];
    }
}
