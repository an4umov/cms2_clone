<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\components\helpers\ContentHelper;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\SpecialOffers;
use yii\base\Widget;
use yii\db\Expression;

// СВЯЗАННЫЕ СТАТЬИ
class RelatedNewsWidget extends Widget
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
        $articles = ContentHelper::getCrossArticles($this->number);
        $rows = ContentHelper::getRelatedContentByArticles($articles, $this->limit);

        if (!$rows) {
            return '';
        }

        return $this->render('related_news', [
            'models' => $rows,
            'articles' => $articles,
        ]);
    }
}
