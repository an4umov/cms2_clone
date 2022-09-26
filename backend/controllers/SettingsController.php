<?php

namespace backend\controllers;

use common\components\helpers\CatalogHelper;
use common\components\helpers\ConsoleHelper;
use Yii;
use common\models\SettingsMainShopLevel;
use common\components\helpers\AppHelper;
use common\models\Catalog;
use common\models\Content;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * SettingsController implements the CRUD actions for Tile model.
 */
class SettingsController extends Controller
{
    /**
     * Lists all Tile models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionHeader()
    {
        $model = $this->findModel(Content::SETTING_HEADER_ID, Content::TYPE_SETTING);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->cache->delete(AppHelper::HEADER_SETTINGS);

            return $this->redirect(['index',]);
        }

        return $this->render('header', [
            'model' => $model,
        ]);
   }

    public function actionFooter()
    {
        $model = $this->findModel(Content::SETTING_FOOTER_ID, Content::TYPE_SETTING);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',]);
        }

        return $this->render('footer', [
            'model' => $model,
        ]);
    }

    public function actionShop()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if (!empty($post['type'])) {
                SettingsMainShopLevel::deleteAll([]);

                foreach ($post['type'] as $code => $type) {
                    $model = new SettingsMainShopLevel();
                    $model->code = $code;
                    $model->type = $type;
                    $model->save();
                }
            }
        }

        $catalogs = CatalogHelper::getMainShopLevelSettings();

        return $this->render('shop', [
            'catalogs' => $catalogs,
        ]);
    }

    public function actionMigration()
    {
        return $this->render('migration');
    }

    public function actionMigrate()
    {
        $this->layout = false;

        $log = [];
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if (!empty($post['table']) && is_array($post['table'])) {
                set_time_limit(0);

                foreach ($post['table'] as $table => $value) {
                    if (!empty($value)) {
                        $log[$table] = ConsoleHelper::migrateCatalog($table, false);
                    }
                }
            }
        }

        return $this->render('migrate', [
            'log' => $log,
        ]);
    }

    public function actionNews()
    {
        $model = AppHelper::getNewsSettings();

        if ($model->load(Yii::$app->request->post())) {
            $model->setData(['news_title' => $model->news_title, 'news_count' => $model->news_count, 'news_is_expand' => $model->news_is_expand,]);

            if ($model->save()) {
                return $this->redirect(['index',]);
            }
        }

        return $this->render('news', [
            'model' => $model,
        ]);
   }

    public function actionMacro()
    {
        return $this->render('macro');
    }

    public function actionCheckout()
    {
        $model = AppHelper::getNewsSettings();

        if ($model->load(Yii::$app->request->post())) {
            $model->setData(['news_title' => $model->news_title, 'news_count' => $model->news_count, 'news_is_expand' => $model->news_is_expand,]);

            if ($model->save()) {
                return $this->redirect(['index',]);
            }
        }

        return $this->render('checkout', [
            'model' => $model,
        ]);
    }
    /**
     * @param int    $id
     * @param string $type
     *
     * @return Content|null
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id, string $type)
    {
        if (($model = Content::findOne(['id' => $id, 'type' => $type, 'deleted_at' => null,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
