<?php

namespace frontend\controllers;

use common\components\helpers\AppHelper;
use common\components\helpers\CatalogHelper;
use common\components\helpers\DepartmentHelper;
use common\components\helpers\FavoriteHelper;
use common\models\Articles;
use common\models\Catalog;
use common\models\Content;
use common\models\ContentFilter;
use common\models\Department;
use common\models\DepartmentMenu;
use common\models\DepartmentMenuTag;
use common\models\DepartmentMenuTagList;
use frontend\components\widgets\CatalogListWidget;
use frontend\components\widgets\DepartmentMenuWidget;
use \Yii;
use frontend\models\search\CatalogTreeSearch;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ShopController extends Controller
{
    public function actionVendor(string $number)
    {
        $model = CatalogHelper::getArticleModelByNumber($number);

        if (!$model) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('vendor', [
            'model' => $model,
            'title' => $model->title ? $model->title : $model->name,
        ]);
    }

    public function actionProduct(string $number, string $key)
    {
        $product = CatalogHelper::getCatalogModelByProductKey($key);
        $model = CatalogHelper::getArticleModelByNumber($number);
        if (!$model or $model->number !== $product->article_number) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('/vendor/view', [
            'product' => $product,
            'model' => $model
        ]);
    }

    // public function actionProduct(string $code)
    // {
    //     $key = Yii::$app->request->get('id');

    //     return $this->render('product', [
    //         'code' => $code,
    //         'key' => $key,
    //     ]);
    // }

    /**
     * @param        $alias
     * @param string      $shop
     * @param string|null $menu
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionNewsAlias(string $shop, string $menu = null, string $alias)
    {
        $model = $this->_findContentModel($alias, 'news');
        $shop = \Yii::$app->request->get('shop', '');

        $model->incViewsCount();

        return $this->render('news', [
            'model' => $model,
            'shop' => $shop,
        ]);
    }

    /**
     * @param        $alias
     * @param string $type
     *
     * @return Content
     * @throws NotFoundHttpException
     */
    private function _findContentModel($alias, string $type) : Content
    {
        $model = Content::find()->where(['type' => $type, 'deleted_at' => null,])->andWhere(['or', '"alias" = :alias', '"id" = :alias_int',])->addParams([':alias' => $alias, ':alias_int' => intval($alias),])->one();

        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException('Контент не найден');
    }

    /**
     * @param string      $shop
     * @param string|null $menu
     * @param string|null $alias
     * @param string|null $tag
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShop(string $shop, string $menu = null, string $tag = null, string $alias = null)
    {
        $activeCarModel = null;
        $catalogCode = null;

        $group = (string) Yii::$app->request->get('group', '');

        $department = DepartmentHelper::getDepartmentByUrl($shop);
        if (empty($department->default_menu_id)) {
            throw new NotFoundHttpException('Не указано меню по умолчанию для департамента');
        }

        $isGroupDepartment = CatalogHelper::isGroupDepartment($shop);
        $defaultMenu = $department->getDefaultMenu()->one();

        //news 
        $model = '';
        if (!empty($alias)) {
            $model = $this->_findContentModel($alias, 'news');

            $model->incViewsCount();
        }

        $shop = \Yii::$app->request->get('shop', '');

        // Cookies
        CatalogHelper::setDepartmentsViewCookie($shop, $isGroupDepartment);

        if (empty($menu) && empty($tag) && empty($alias)) { // /dep/discovery3
            $url = ['shop/shop', 'shop' => $shop, 'menu' => $defaultMenu->url,];
            if (!empty($group)) {
                $url['group'] = $group;
            }

            return $this->redirect(Url::to($url)); // /dep/discovery3/shop
        } else {
            if (!empty($menu)) {
                if (CatalogHelper::isCatalogCode($menu)) { // /dep/discovery3/KAT0001798
                    $url = ['shop/shop', 'shop' => $shop, 'menu' => $defaultMenu->url, 'tag' => $menu,];
                    if (!empty($group)) {
                        $url['group'] = $group;
                    }

                    return $this->redirect(Url::to($url)); // /dep/discovery3/shop/KAT0001798
                }
            }
        }

        $pageData = [];
        $pageData['title'] = $department->name;
        $pageData['content'] = '';

        $breadcrumbs = [
            ['label' => $isGroupDepartment ? 'Группы товаров' : 'Модели авто', 'url' => $isGroupDepartment ? '/departments' : '/models',],
            ['label' => $department->name, 'url' => Url::to(['shop/shop', 'shop' => $department->url,])],
        ];

        if (!empty($menu)) {
            if (CatalogHelper::isCatalogCode($menu)) {
                $catalogCode = $menu;
                $menu = '';

                //Last view cookie
                $url = Url::to(['shop/shop', 'shop' => $department->url, 'menu' => $menu,]);
                if ($isGroupDepartment) {
                    AppHelper::setCookieValue(CatalogHelper::COOKIE_GROUPS_LAST_URL, $url);
                } else {
                    AppHelper::setCookieValue(CatalogHelper::COOKIE_MODELS_LAST_URL, $url);
                }
            } else {
                $menuModel = DepartmentHelper::getDepartmentMenuByUrl($department->id, $menu);
                $breadcrumbs[] = ['label' => $menuModel->name, 'url' => Url::to(['shop/shop', 'shop' => $department->url, 'menu' => $menuModel->url,])];
                $pageData['title'] .= ' / '.$department->name;

                if (!empty($tag)) {
                    if (CatalogHelper::isCatalogCode($tag)) {
                        $catalogCode = $tag;
                        $tag = '';
                    } else {
                        $tagModel = DepartmentHelper::getDepartmentMenuTagByUrl($menuModel->id, $tag);
                        $breadcrumbs[] = ['label' => $tagModel->name, 'url' => Url::to(['shop/shop', 'shop' => $department->url, 'menu' => $menuModel->url, 'tag' => $tagModel->url,])];
                        $pageData['title'] .= ' / '.$tagModel->name;
                    }
                }
            }
        }

        if ($catalogCode) {
            $catalogCodeModel = CatalogHelper::getCatalogModelByCode($catalogCode);
            $breadcrumbs[] = ['label' => $catalogCodeModel->name, 'url' => Url::to(CatalogHelper::getBaseCatalogRoute($department, $menu, $tag, $catalogCode))];
        }

        if ($alias) {
            $breadcrumbs[] = ['label' => $model['title'], 'url' => Url::to(CatalogHelper::getBaseCatalogRoute($department, $menu, $tag, $catalogCode))];
        }

        return $this->render('shop', [
            'id' => 'shop-content-list',
            'shop' => $shop,
            'carModelID' => 0,
            'pageData' => $pageData,
            'department' => $department, //Department
            'activeCarModel' => $activeCarModel, //array
            'activeDepartmentMenu' => $menu, //string
            'activeDepartmentMenuTag' => $tag, //string
            'newsAlias' => $alias, //string
            'catalogCode' => $catalogCode, //string
            'tree' => DepartmentHelper::getSimpleDepartmentsTreeData($department), //array
            'breadcrumbs' => $breadcrumbs, //array
            'isGroupDepartment' => $isGroupDepartment, //bool
            'group' => $group, //string
            'model' => $model, //string
        ]);
    }

    /**
     * @param string $code
     *
     * @return Articles
     * @throws NotFoundHttpException
     */
    private function _findArticleModel(string $code) : Articles
    {
        $model = Articles::findOne(['number' => $code,]);

        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException('Статья не найдена по коду '.$code);
    }
}