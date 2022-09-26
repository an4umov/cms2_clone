<?php

namespace frontend\controllers;

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use common\models\Articles;
use common\models\ParserLrpartsItems;
use Yii;
use frontend\models\search\LrPartsSearch;
use common\models\ParserLrpartsRubrics;
use common\models\search\ParserLrpartsItemsSearch;
use common\components\helpers\ParserHelper;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class LrPartsController extends Controller
{
    const BREADCRUMB_NAME = 'Каталог Land Rover';
    const SEARCH_POST = 'SEARCH_POST';

    public $layout = 'lrparts';

    public function init()
    {
        parent::init();
        \Yii::$app->errorHandler->errorAction = 'lr-parts/error';
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@frontend/views/lr-parts/error'
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'title' => self::BREADCRUMB_NAME,
            'models' => ParserLrpartsRubrics::find()->where(['parent_id' => 0, 'is_active' => true,])->orderBy(['sort_field' => SORT_ASC,])->indexBy('id')->asArray(false)->all(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $model = $this->findModel($id);

        if (empty($model->is_active)) {
            throw new NotFoundHttpException('Рубрика недоступна для просмотра');
        }

        $items = [];
        if (!empty($model->is_last)) {
            $searchModel = new ParserLrpartsItemsSearch();
            $searchModel->rubric_id = $id;
            $searchModel->is_active = true;
            $searchModel->isNameFromArticles = true;
            $items = $searchModel->search([])->getModels();
        }

        $params = [
            'model' => $model,
            'children' => $model->children,
            'items' => $items,
            'breadcrumbs' => ParserHelper::getLrpartsRubricBreadcrumbs($id),
        ];

        return $this->render('view', $params);
    }

    /**
     * @param string $text
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSearch(string $text = '')
    {
        if (Yii::$app->request->isPost) {
            $text = trim(Yii::$app->request->post(LrPartsSearch::TEXT, ''));

            if ($text) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }

                $_SESSION[self::SEARCH_POST] = $_POST;

                return $this->redirect(['lr-parts/search', 'text' => $text,]);
            }
        }

        $request = [];
        if (Yii::$app->request->isGet) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
            if (isset($_SESSION[self::SEARCH_POST])) {
                $request = $_SESSION[self::SEARCH_POST];
                unset($_SESSION[self::SEARCH_POST]);
            }
        }

        $params = [LrPartsSearch::TEXT => '',];
        if (!empty($text)) {
            $params[LrPartsSearch::TEXT] = trim($text);
        }

        if (!empty($request[LrPartsSearch::SEARCH_IN_NAME])) {
            $params[LrPartsSearch::SEARCH_IN_NAME] = true;
        } else {
            $params[LrPartsSearch::SEARCH_IN_NAME] = false;
        }

        $errors = [];
        $searchModel = new LrPartsSearch();
        $searchModel->load($params);

        if (!$searchModel->validate()) {
            $errors = $searchModel->getErrors();
        }

        $dataProvider = $searchModel->search($params);
        $query = $dataProvider->query;
        $countQuery = clone $dataProvider->query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(),]);

        $query->leftJoin(Articles::tableName(), 'lower('.ParserLrpartsItems::tableName().'.code) = lower('.Articles::tableName().'.number)');
        $query->select(ParserLrpartsItems::tableName().'.*');
        $query->addSelect(Articles::tableName().'.name as article_name');

        /** @var ParserLrpartsItems[] $models */
        $models = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy([Articles::tableName().'.name' => SORT_ASC,])
            ->asArray()
            ->all();

//        $models = $dataProvider->getModels();
        if (!$models) {
            $this->view->params['searchModel'] = $searchModel;

            throw new NotFoundHttpException('Ничего не найдено');
        }

        $cookieValue = AppHelper::getCookieValue(CatalogHelper::COOKIE_LRPARTS_SEARCH);

        if (empty($cookieValue)) {
            $searchResults = [];
        } else {
            $searchResults = Json::decode($cookieValue);
        }

//        print_r($models);exit;

        $rubrics = $items = [];
        foreach ($models as $model) {
            $labels = [];
            $breadcrumbs = ParserHelper::getLrpartsRubricBreadcrumbs($model['rubric_id']);
            foreach ($breadcrumbs as $breadcrumb) {
                $labels[] = Html::a($breadcrumb['label'], $breadcrumb['url']);
            }

            $rubrics[$model['code']][] = implode(' ', $labels);
            $items[$model['code']] = $model;
        }

        foreach ($models as $model) {
            if (!isset($searchResults[$model['code']])) {
                $searchResults[$model['code']] = [
                    'name' => $model['name'],
                    'rubric_id' => $model['rubric_id'],
                ];
            }

            break;
        }

        unset($models);

        AppHelper::setCookieValue(CatalogHelper::COOKIE_LRPARTS_SEARCH, Json::encode($searchResults), (time() + 86400 * 365));

        return $this->render('search', [
            'params' => $params,
            'errors' => $errors,
            'searchModel' => $searchModel,
            'rubrics' => $rubrics,
            'items' => $items,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @param integer $id
     *
     * @return ParserLrpartsRubrics|null
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id)
    {
        if (($model = ParserLrpartsRubrics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Рубрика каталога с ID '.$id.' не найдена');
    }
}