<?php

namespace frontend\controllers;

use common\models\Content;
use frontend\models\search\ContentSearch;
use frontend\models\search\FilterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ContentController extends Controller
{
    public function actionPagesIndex()
    {
        return $this->_getIndex(Content::TYPE_PAGE);
    }

    public function actionArticlesIndex()
    {
        return $this->_getIndex(Content::TYPE_ARTICLE);
    }

    public function actionNewsIndex()
    {
        return $this->_getIndex(Content::TYPE_NEWS);
    }

    public function actionPagesAlias($alias)
    {
        return $this->_getAlias($alias, Content::TYPE_PAGE);
    }

    public function actionArticlesAlias($alias)
    {
        return $this->_getAlias($alias, Content::TYPE_ARTICLE);
    }

    public function actionNewsAlias($alias)
    {
        return $this->_getAlias($alias, Content::TYPE_NEWS);
    }

    /**
     *
     *
     * @return string
     */
    public function actionSearch()
    {
        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('search', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param string $type
     *
     * @return string
     */
    private function _getIndex(string $type) : string
    {
        switch ($type) {
            case 'news':
                $label = 'Новости';
                break;
            
            default:
                $label = '/';
                break;
        }
        $breadcrumbs = [
            ['label' => $label, 'url' => ''],
        ];
        return $this->render('index', [
            'type' => $type,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @param        $alias
     * @param string $type
     *
     * @return string
     * @throws NotFoundHttpException
     */
    private function _getAlias($alias, string $type) : string
    {
        $model = $this->_findContentModel($alias, $type);
        $shop = \Yii::$app->request->get('shop', '');

        $model->incViewsCount();

        return $this->render('view', [
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
}