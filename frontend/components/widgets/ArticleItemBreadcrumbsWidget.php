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

class ArticleItemBreadcrumbsWidget extends Widget
{
    /**
     * @var Articles
     */
    public $model;

    /** @var string */
    public $id = 'article-item-breadcrumbs-list';

    public function init()
    {
        parent::init();

        if (empty($this->model)) {
            throw new NotFoundHttpException('Отсутствует модель артикула');
        }
    }

    public function run()
    {
        $data = $catalogData = [];

        $catalogModels = Catalog::findAll(['article' => $this->model->number,]);
        if ($catalogModels) {
            $catalogData = CatalogHelper::getCatalogListData(CatalogListWidget::CODE_LAND_ROVER, true);

            foreach ($catalogModels as $catalogModel) {
                $breadcrumbs = CatalogHelper::getCatalogBreadcrumbs($catalogData, $catalogModel->code);
                if (!empty($breadcrumbs)) {
                    $data[$catalogModel->code] = $breadcrumbs;
                }
            }
        }

        return $this->render('article_item_breadcrumbs_list', [
            'model' => $this->model,
            'data' => $data,
            'catalogData' => $catalogData,
        ]);
    }
}
