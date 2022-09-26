<?php

namespace backend\modules\cart\controllers;

use common\components\helpers\AppHelper;
use common\components\helpers\CartHelper;
use common\components\helpers\ParserHelper;
use common\models\Articles;
use common\models\CartSettings;
use common\models\Settings;
use yii\web\UploadedFile;
use common\models\ParserLrpartsItems;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Default controller for the `Cart` module
 */
class CartSettingsController extends Controller
{
    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $model = null;
        $id = Yii::$app->request->get('id', 0);
        if ($id) {
            $model = $this->findModel($id);
        }

        return $this->render('index', ['model' => $model,]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $model = $this->findModel($id);
        $isAjax = Yii::$app->request->isAjax;

        if (!$isAjax) {
            throw new BadRequestHttpException('Only AJAX');
        }

        $params = [
            'model' => $model,
        ];

        return $this->renderAjax('view', $params);
    }

    /**
     * @param int $pid
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionAdd(int $pid)
    {
        $parentModel = $this->findModel($pid);

        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('Only AJAX');
        }

        $model = new CartSettings();
        $model->parent_id = $parentModel->id;
        $model->level = ++$parentModel->level;

        return $this->renderAjax('add', ['model' => $model, 'parentModel' => $parentModel,]);
    }

    /**
     * @return array|bool[]
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            $id = $post['CartSettings']['id'] ?? 0;

            if (!$id) { //Сохранение глоб. настроек
                $globalSettings = AppHelper::getCartSettings();

                $successMessage = $post[Settings::CART_SUCCESS_MESSAGE_KEY] ?? '';
                $failureMessage = $post[Settings::CART_FAILURE_MESSAGE_KEY] ?? '';

                $globalSettings->setData([Settings::CART_SUCCESS_MESSAGE_KEY => $successMessage, Settings::CART_FAILURE_MESSAGE_KEY => $failureMessage,]);
                $isSaved = $globalSettings->save();

                return ['ok' => $isSaved,];
            } else {
                $model = $this->findModel($id);

                if ($model->load($post)) {
                    // Приоритет у файла с компа
                    $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                    if ($imageName = $model->upload()) {
                        $model->image = $imageName;
                    }

                    if ($model->save()) {
                        return ['ok' => true,];
                    } else {
                        return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
                    }
                }
            }
        }

        throw new BadRequestHttpException('Неверный запрос на обновление настроек');
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionAddSetting()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $post = Yii::$app->request->post();

            $model = new CartSettings();

            if ($model->load($post)) {
                $maxSort = (int) CartSettings::find()->where(['parent_id' => $model->parent_id,])->max('sort');
                $model->sort = $maxSort + 1;

                if ($model->save()) {
                    return ['ok' => true, 'id' => $model->id,];
                } else {
                    return ['ok' => false, 'message' => 'Ошибка сохранения: '.print_r($model->getFirstErrors(), true),];
                }
            } else {
                return ['ok' => false, 'message' => 'Ошибка сохранения!',];
            }
        }

        throw new BadRequestHttpException('Неверный запрос на добавление рубрики');
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveSetting()
    {
        $post = Yii::$app->request->post();
        $id = $post['id'] ?? 0;

        if (!$id) {
            throw new BadRequestHttpException('Отсутствует обязательный параметр');
        }

        $deleted = $this->findModel($id)->delete();
        if ($deleted) {
            $deletedID = $id;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['ok' => $deletedID,];
    }

    /**
     * @param $id
     *
     * @return CartSettings|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if ($id === CartHelper::CART_SETTINGS_GLOBAL_ID) {
            $model = new CartSettings();
            $model->id = CartHelper::CART_SETTINGS_GLOBAL_ID;
            $model->level = 0;
            $model->parent_id = 0;
            $model->name = 'Общее';
            $model->globalSettings = AppHelper::getCartSettings();

            return $model;
        }

        if (($model = CartSettings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
