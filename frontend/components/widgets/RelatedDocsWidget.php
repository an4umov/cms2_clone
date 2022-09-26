<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\components\helpers\ContentHelper;
use common\components\helpers\DocumentHelper;
use common\models\ArticleRecomend;
use common\models\Articles;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\SpecialOffers;
use yii\base\Widget;
use yii\db\Expression;

// СВЯЗАННЫЕ ТОВАРЫ
class RelatedDocsWidget extends Widget
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

        return $this->render('related_docs', [
            'rows' => DocumentHelper::getDocuments($articles),
        ]);
    }
}
