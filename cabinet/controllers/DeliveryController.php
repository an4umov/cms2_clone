<?php
namespace cabinet\controllers;

use common\components\helpers\UserHelper;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\UserDelivery;

/**
 * Delivery controller
 */
class DeliveryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionIndex()
    {
        /** @var \cabinet\components\UserLk $model */
        $user = Yii::$app->user;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $userDeliveryPost = $post['UserDelivery'] ?? [];

            if (!empty($userDeliveryPost['id'])) {
                $deliveryModel = $this->findUserDelivery($userDeliveryPost['id']);
            } else {
                $deliveryModel = new UserDelivery();
            }

            $deliveryModel->load($post);
            $deliveryModel->user_id = $user->id;
            if (empty($userDeliveryPost['is_main'])) {
                $deliveryModel->is_main = false;
            }
            if (empty($userDeliveryPost['is_post'])) {
                $deliveryModel->is_post = false;
            }

            if ($deliveryModel->save()) {
                if (!empty($deliveryModel->is_main)) {
                    UserDelivery::updateAll(['is_main' => false,], ['AND', ['user_id' => $user->id], ['<>', 'id', $deliveryModel->id,],]);
                }
                if (!empty($deliveryModel->is_post)) {
                    UserDelivery::updateAll(['is_post' => false,], ['AND', ['user_id' => $user->id], ['<>', 'id', $deliveryModel->id,],]);
                }

                if (!empty($userDeliveryPost['id'])) {
                    Yii::$app->session->setFlash('success', 'Адрес обновлен');
                } else {
                    Yii::$app->session->setFlash('success', 'Адрес создан');
                }
            }
        }

        $deliveries = UserDelivery::find()->where(['user_id' => $user->id, 'deleted_at' => null,])->orderBy(['updated_at' => SORT_DESC,])->all();
        $newDelivery = new UserDelivery();
        $newDelivery->initModel();

        array_push($deliveries, $newDelivery);

        return $this->render('index', [
            'deliveries' => $deliveries,
            'lkSettings' => UserHelper::getLkSettings(),
        ]);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        if ($this->findUserDelivery($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Адрес удален');
        }

        return $this->redirect(['index']);
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionCheck()
    {
        $delivery = new UserDelivery();

        if (Yii::$app->request->isAjax && $delivery->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return \yii\widgets\ActiveForm::validate($delivery);
        }

        throw new BadRequestHttpException();
    }

    /**
     * @param $id
     *
     * @return UserDelivery|null
     * @throws NotFoundHttpException
     */
    protected function findUserDelivery($id)
    {
        $user = Yii::$app->user;
        if (($model = UserDelivery::findOne(['id' => $id, 'user_id' => $user->id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Адрес доставки не найден');
    }
}
