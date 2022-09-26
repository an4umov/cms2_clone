<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\components\helpers\ContentHelper;
use common\models\ArticleRecomend;
use common\models\Articles;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\SpecialOffers;
use yii\base\Widget;
use yii\db\Expression;

// СВЯЗАННЫЕ ТОВАРЫ
class RelatedProductsWidget extends Widget
{
    const LIMIT = 10;

    public $number;
    public $limit;

    public function init()
    {
        parent::init();

        if (is_null($this->limit)) {
            $this->limit = self::LIMIT;
        }
    }

    public function run()
    {
        $query = ArticleRecomend::find();
        $query->where(['number' => $this->number,]);
        $query->asArray();

        $rows = $query->all();
        if (!$rows) {
            return '';
        } else {
            foreach ($rows as $i => $row) {
                $articles = explode(',', $row['articles']);

                $rows[$i]['articles'] = [];
                foreach ($articles as $number) {
                    $query = Articles::find()->where(['number' => $number,])->asArray();
                    $query->select([
                        Articles::tableName().'.name',
                        Articles::tableName().'.number',
                        Articles::tableName().'.description',
                        Articles::tableName().'.title',
                        new Expression("(SELECT MIN(price) FROM public.".PriceList::tableName()."	WHERE ".PriceList::tableName().".article_number=".Articles::tableName().".number) as price"),
                    ]);

                    $rows[$i]['articles'][$number] = $query->one();
                }

                if (empty($row['color'])) {
                    $rows[$i]['color'] = ReclamaStatus::getRandomColor();
                }
            }
        }

        return $this->render('related_products', [
            'models' => $rows,
        ]);
    }
}
