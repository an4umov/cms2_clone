<?php

namespace frontend\controllers;

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use common\models\Catalog;
use common\models\Department;
use common\models\GreenMenu;
use common\models\SettingsMainShopLevel;
use frontend\components\widgets\CatalogListWidget;
use frontend\components\widgets\ProductOffersWidget;
use \Yii;
use frontend\models\search\CatalogTreeSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CatalogController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'view' => ['GET',],
                    'test' => ['GET',],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', ['title' => Catalog::TITLE,]);
    }

    public function actionDepartments()
    {
        $breadcrumbs = [
            ['label' => 'Группы товаров', 'url' => '/departments'],
        ];

        $departmentMenu = GreenMenu::find()->where(['is_department_menu' => true, 'is_enabled' => true,])->with('landingPage')->one();
        if (!$departmentMenu) {
            throw new NotFoundHttpException('Не задан пункт меню');
        }

        $trees = [];
        $groupsModel = CatalogHelper::getCatalogModelByCode(Catalog::ITEM_GROUPS_CODE);

        $trees[$groupsModel->code] = CatalogHelper::getCatalogTreeData($groupsModel);

        $departments = [];
        $rows = Department::find()->select(['url', 'catalog_code', 'name',])->asArray()->all();
        foreach ($rows as $row) {
            if (!empty($row['catalog_code'])) {
                $departments[$row['catalog_code']] = $row;
            }
        }

        return $this->render('departments', ['breadcrumbs' => $breadcrumbs, 'departmentMenu' => $departmentMenu, 'trees' => $trees, 'departments' => $departments, 'activeGeneration' => '',]);
    }

    /**
     * @return string
     */
    public function actionModels()
    {
        $groupTitle = '';
        $group = (string) Yii::$app->request->get('group', '');

        $breadcrumbs = [
            ['label' => 'Модели Авто', 'url' => '/models'],
        ];

        $types = Catalog::find()->where(['level' => Catalog::LEVEL_3, 'is_product' => Catalog::IS_PRODUCT_NO, 'is_department' => false,])->orderBy(['order' => SORT_ASC])->asArray(false)->all();
        $activeType = $types ? current($types) : null;

        $trees = [];
        foreach ($types as $type) {
            $trees[$type->code] = CatalogHelper::getCatalogTreeData($type);

            if ($type->code === Catalog::CARS_CODE) {
                $type->tabClass = 'model-auto__brand--cars';
            } else {
                $type->tabClass = 'model-auto__brand--trucks';
            }
        }

        $departments = [];
        $rows = Department::find()->select(['url', 'catalog_code', 'name',])->asArray()->all();
        foreach ($rows as $row) {
            if (!empty($row['catalog_code'])) {
                $departments[$row['catalog_code']] = $row;
            }
        }

        // Подсчет кол-ва "разделы-цели" для "ссылка-цель"
        if (!empty($group)) {
            $structureData = CatalogHelper::getCatalogStructureData();
            $groupTitle = isset($structureData[$group]) ? $structureData[$group]['link_tag'] : '';
            if (!empty($groupTitle)) {
                CatalogHelper::calculateTagForLink($trees, $groupTitle);
            }
        }

        return $this->render('models', [
            'breadcrumbs' => $breadcrumbs,
            'types' => $types,
            'activeType' => $activeType ? $activeType->code : '',
            'activeBrand' => '',
            'activeModel' => '',
            'activeGeneration' => '',
            'trees' => $trees,
            'departments' => $departments,
            'group' => $group,
            'groupTitle' => $groupTitle,
        ]);
    }

    public function actionShop()
    {
        $data = [SettingsMainShopLevel::TYPE_ONE => [], SettingsMainShopLevel::TYPE_TWO => [], SettingsMainShopLevel::TYPE_THREE => [],];
        $settings = CatalogHelper::getMainShopLevelSettings();

        foreach ($settings as $code => $setting) {
            $data[$setting['type']][] = $setting;
        }

        return $this->render('shop', ['title' => Catalog::TITLE, 'settings' => $settings, 'data' => $data,]);
    }

    /**
     * @param string $code
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOffers(string $code)
    {
//        if (!Yii::$app->request->isAjax) {
//            throw new BadRequestHttpException('Неверное обращение');
//        }

        $isStock = (bool) Yii::$app->request->get('stock', false);
        $url = (string) Yii::$app->request->post('url', '');
        $params = [ProductOffersWidget::PARAM_FILTER => ['isStock' => $isStock,],];

        $model = CatalogHelper::getCatalogModelByCode($code);

        if (!empty($model->copy_of)) {
            $model = CatalogHelper::getCatalogModelByCode($model->copy_of);
        }

        $articles = Catalog::find()->select(['article',])->where(['parent_code' => $model->code, 'is_product' => Catalog::IS_PRODUCT_YES,])->orderBy(['order' => SORT_ASC,])->asArray()->column();
        if (!empty($articles)) {
            $params[ProductOffersWidget::PARAM_NUMBERS] = array_unique($articles);
        }

        if ($url) {
            //Last view models cookie
            AppHelper::setCookieValue(CatalogHelper::COOKIE_MODELS_LAST_URL, $url);
        }

        //actually render product_offers widget

        return $this->renderAjax('offers', [
            'params' => $params,
        ]);
    }

    /**
     * @param string $code
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws Yii\web\BadRequestHttpException
     * @throws Yii\web\HttpException
     */
    public function actionView(string $code)
    {
        if (!Yii::$app->request->isGet) {
            throw new yii\web\HttpException(400, Yii::t('app', 'Request error'));
        }
        if (empty($code)) {
            throw new yii\web\BadRequestHttpException(Yii::t('app', 'Bad request'));
        }

        $isTree = (bool) Yii::$app->request->get('tree', false);
        $isStock = (bool) Yii::$app->request->get('stock', false);

        $model = CatalogHelper::getCatalogModelByCode($code);
        $topLevelModelData = (new CatalogTreeSearch())->findTopLevelModel($model);
//        print_r($topLevelModelData);exit;
        if (!empty($topLevelModelData['model'])) {
            $tree = CatalogHelper::getCatalogTreeData($topLevelModelData['model']);
        } else {
            throw new NotFoundHttpException('Код указан не верно');
        }

        $isFinalItem = Catalog::find()->where(['parent_code' => $code, 'is_product' => Catalog::IS_PRODUCT_YES,])->exists();
        $isArticles = false;

        return $this->render('view', [
            'tree' => $tree,
            'isTree' => $isTree,
            'isFinalItem' => $isFinalItem,
            'model' => $model,
            'isArticles' => $isArticles,
//            'setting' => CatalogHelper::getCatalogTreeSetting(),
            'activeCode' => $code,
            'codes' => $topLevelModelData['codes'],
            'filter' => [
                'stock' => $isStock,
            ],
            'baseUrlRoute' => [],
            'rubricTitles' => CatalogHelper::getRubricTitles($tree, $code),
        ]);
    }

    public function actionCategory(string $code)
    {
        $model = CatalogHelper::getCatalogModelByCode($code);
        $breadcrumbs = CatalogHelper::getCatalogBreadcrumbs(CatalogHelper::getCatalogListData(CatalogListWidget::CODE_LAND_ROVER), $model->code);

        $setting = CatalogHelper::getCatalogTreeSetting();
        $tree = (new CatalogTreeSearch());
        $level = 1;
        $firstCode = $title = $content = '';
        foreach ($breadcrumbs as $i => $breadcrumb) {
            $title = $breadcrumb['label'];
            $childCode = $breadcrumb['url']['code'];
            if ($level === Catalog::LEVEL_1) {
                $firstCode = $childCode;
            }
            $isArticles = false;
            $dataProvider = $tree->search(['code' => $childCode,]);
            $childrenModel = CatalogHelper::getCatalogModelByCode($childCode);

            if (!$dataProvider->getTotalCount()) {
                $dataProvider = $tree->searchArticles(['code' => $childCode,]);
                $isArticles = true;
            }

            $data = [
                'dataProvider' => $dataProvider,
                'level' => $level,
                'model' => $childrenModel,
                'groupTitle' => $childrenModel->name,
                'breadcrumbs' => [],
                'isArticles' => $isArticles,
                'setting' => $setting,
                'nextCode' => isset($breadcrumbs[$i + 1]) ? $breadcrumbs[$i + 1]['url']['code'] : '',
            ];

            $content .= $this->renderPartial('view', $data);

            $level++;
        }

        array_unshift($breadcrumbs, ['label' => Catalog::TITLE, 'url' => ['/catalog',], 'template' => CatalogHelper::BREADCRUMB_TEMPLATE,]);

        return $this->render('category', [
            'breadcrumbs' => $breadcrumbs,
            'content' => $content,
            'firstCode' => $firstCode,
            'title' => $title,
        ]);
    }
}