<?php

namespace frontend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\components\helpers\ContentHelper;
use common\models\Catalog;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\SpecialOffers;
use yii\base\Widget;
use yii\db\Expression;

// СВЯЗАННЫЕ РАЗДЕЛЫ МАГАЗИНА
class RelatedSectionsWidget extends Widget
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
        $rows = ContentHelper::getCatalogRubricsByArticles($articles, $this->limit);

        if (!$rows) {
            return '';
        }

        foreach ($rows as $i => $row) {
            $images = CatalogHelper::scanCatalogImages($row['code']);
            if ($images) {
                $image = array_shift($images);
                $rows[$i]['image'] = $image;
            } else {
                $rows[$i]['image'] = '/img/'.Catalog::IMAGE_NOT_AVAILABLE_180;
            }
        }

        return $this->render('related_sections', [
            'models' => $rows,
        ]);
    }
}
