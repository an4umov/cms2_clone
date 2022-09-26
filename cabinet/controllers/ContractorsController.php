<?php
namespace cabinet\controllers;

use common\components\helpers\UserHelper;
use common\models\UserContact;
use common\models\UserContractorEntity;
use common\models\UserContractorPayment;
use common\models\UserContractorPerson;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Contractors controller
 */
class ContractorsController extends Controller
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
            $type = $post['type'] ?? '';

            if ($type === \common\models\UserContractorEntity::class) {
                $userContractorEntityPost = $post['UserContractorEntity'] ?? [];
                if (!empty($userContractorEntityPost['id'])) {
                    $entityModel = $this->findUserContractorEntity($userContractorEntityPost['id']);
                } else {
                    $entityModel = new UserContractorEntity();
                }

                $entityModel->load($post);
                $entityModel->user_id = $user->id;
                if (empty($userContractorEntityPost['is_default'])) {
                    $entityModel->is_default = false;
                }
                if (empty($userContractorEntityPost['is_active'])) {
                    $entityModel->is_active = false;
                }

                if ($entityModel->save()) {
                    if (!empty($entityModel->is_default)) {
                        UserContractorEntity::updateAll(['is_default' => false,], ['AND', ['user_id' => $user->id], ['<>', 'id', $entityModel->id,],]);
                    }

                    if (!empty($userContractorEntityPost['id'])) {
                        Yii::$app->session->setFlash('success', 'Данные обновлены');
                    } else {
                        Yii::$app->session->setFlash('success', 'Юридическое лицо создано');
                    }
                }
            } elseif ($type === \common\models\UserContractorPerson::class) {
                $userContractorPersonPost = $post['UserContractorPerson'] ?? [];
                if (!empty($userContractorPersonPost['id'])) {
                    $personModel = $this->findUserContractorPerson($userContractorPersonPost['id']);
                } else {
                    $personModel = new UserContractorPerson();
                }

                $personModel->load($post);
                $personModel->user_id = $user->id;
                if (empty($userContractorPersonPost['is_default'])) {
                    $personModel->is_default = false;
                }
                if (empty($userContractorPersonPost['is_active'])) {
                    $personModel->is_active = false;
                }

                if ($personModel->save()) {
                    if (!empty($personModel->is_default)) {
                        UserContractorPerson::updateAll(['is_default' => false,], ['AND', ['user_id' => $user->id], ['<>', 'id', $personModel->id,],]);
                    }

                    if (!empty($userContractorPersonPost['id'])) {
                        Yii::$app->session->setFlash('success', 'Данные обновлены');
                    } else {
                        Yii::$app->session->setFlash('success', 'Физическое лицо создано');
                    }
                }
            } else {
                throw new BadRequestHttpException('Неверный тип данных');
            }

//            echo '<pre>';
//            VarDumper::dump($post, 10, 1);
//            exit;
        }

        $entities = UserContractorEntity::find()->with('payments')->where([UserContractorEntity::tableName().'.user_id' => $user->id, UserContractorEntity::tableName().'.deleted_at' => null,])->orderBy([UserContractorEntity::tableName().'.updated_at' => SORT_DESC,])->all();
        $newEntity = new UserContractorEntity();
        $newEntity->initModel();

        $persons = UserContractorPerson::find()->with('payments')->where([UserContractorPerson::tableName().'.user_id' => $user->id, UserContractorPerson::tableName().'.deleted_at' => null,])->orderBy([UserContractorPerson::tableName().'.updated_at' => SORT_DESC,])->all();
        $newPerson = new UserContractorPerson();
        $newPerson->initModel();

        array_push($entities, $newEntity);
        array_push($persons, $newPerson);

        $newPayment = new UserContractorPayment();
        $newPayment->initModel();

        return $this->render('index', [
            'entities' => $entities,
            'persons' => $persons,
            'newPayment' => $newPayment,
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
    public function actionEntityDelete($id)
    {
        if ($this->findUserContractorEntity($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Юр. лицо удалено');
        }

        return $this->redirect(['index']);
    }

    /**
     * @return array
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionEntityPaymentDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $entity_id = Yii::$app->request->post('entity_id');

            if ($id && $entity_id && $this->findUserContractorEntityPayment($id, $entity_id)->delete()) {
                return ['ok' => true,];
            }
        }

        return ['ok' => false,];
    }

    public function actionEntityPaymentSave()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        /** @var \cabinet\components\UserLk $model */
        $user = Yii::$app->user;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $userContractorPaymentPost = $post['UserContractorPayment'] ?? [];
            if (!empty($userContractorPaymentPost['entity_id'])) {
                if (!empty($userContractorPaymentPost['id'])) {
                    $paymentModel = $this->findUserContractorEntityPayment($userContractorPaymentPost['id'], $userContractorPaymentPost['entity_id']);
                } else {
                    $paymentModel = new UserContractorPayment();
                }

                $paymentModel->load($post);
                $paymentModel->user_id = $user->id;
                if (empty($userContractorPaymentPost['is_default'])) {
                    $paymentModel->is_default = false;
                } else {
                    $paymentModel->is_default = true;
                }

                if ($paymentModel->save()) {
                    if (!empty($paymentModel->is_default)) {
                        UserContractorPayment::updateAll(['is_default' => false,], ['AND', ['entity_id' => $paymentModel->entity_id,], ['AND', ['user_id' => $user->id,], ['<>', 'id', $paymentModel->id,],],]);
                    }

                    return ['ok' => true, 'html' => UserHelper::getUserContractorEntityPaymentRowHtml($paymentModel, $paymentModel->entity_id, true), 'id' => $paymentModel->id,];
                }

            } else {
                throw new BadRequestHttpException('Неверный запрос');
            }
        }

        return ['ok' => false,];
    }

    public function actionPersonPaymentSave()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        /** @var \cabinet\components\UserLk $model */
        $user = Yii::$app->user;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            $userContractorPaymentPost = $post['UserContractorPayment'] ?? [];
            if (!empty($userContractorPaymentPost['person_id'])) {
                if (!empty($userContractorPaymentPost['id'])) {
                    $paymentModel = $this->findUserContractorPersonPayment($userContractorPaymentPost['id'], $userContractorPaymentPost['person_id']);
                } else {
                    $paymentModel = new UserContractorPayment();
                }

                $paymentModel->load($post);
                $paymentModel->user_id = $user->id;
                if (empty($userContractorPaymentPost['is_default'])) {
                    $paymentModel->is_default = false;
                } else {
                    $paymentModel->is_default = true;
                }

                if ($paymentModel->save()) {
                    if (!empty($paymentModel->is_default)) {
                        UserContractorPayment::updateAll(['is_default' => false,], ['AND', ['person_id' => $paymentModel->person_id,], ['AND', ['user_id' => $user->id,], ['<>', 'id', $paymentModel->id,],],]);
                    }

                    return ['ok' => true, 'html' => UserHelper::getUserContractorPersonPaymentRowHtml($paymentModel, $paymentModel->person_id, true), 'id' => $paymentModel->id,];
                } else {
                    return ['ok' => false, 'errors' => $paymentModel->getErrors(),];
                }
            } else {
                throw new BadRequestHttpException('Неверный запрос');
            }
        }

        return ['ok' => false,];
    }

    /**
     * @param $id
     * @param $person_id
     *
     * @return array
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionPersonPaymentDelete($id, $person_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($this->findUserContractorPersonPayment($id, $person_id)->delete()) {
            return ['ok' => true,];
        }

        return ['ok' => false,];
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionPersonDelete($id)
    {
        if ($this->findUserContractorPerson($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Частное лицо удалено');
        }

        return $this->redirect(['index']);
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionEntityCheck()
    {
        $entity = new UserContractorEntity();

        if (Yii::$app->request->isAjax && $entity->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $entity->user_id = Yii::$app->user->id;

            return \yii\widgets\ActiveForm::validate($entity);
        }

        throw new BadRequestHttpException();
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionPaymentCheck()
    {
        $payment = new UserContractorPayment();

        if (Yii::$app->request->isAjax && $payment->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $payment->user_id = Yii::$app->user->id;

            return \yii\widgets\ActiveForm::validate($payment);
        }

        throw new BadRequestHttpException();
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionPersonCheck()
    {
        $person = new UserContractorPerson();

        if (Yii::$app->request->isAjax && $person->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $person->user_id = Yii::$app->user->id;

            return \yii\widgets\ActiveForm::validate($person);
        }

        throw new BadRequestHttpException();
    }

    public function actionMainContactPerson()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = Yii::$app->user;

        $contact = UserContact::find()->where(['user_id' => $user->id, 'deleted_at' => null, 'is_main' => true,])->one();
        if ($contact) {
            return ['firstname' => $contact->firstname, 'lastname' => $contact->lastname, 'secondname' => $contact->secondname,];
        }

        return [];
    }

    /**
     * @param $id
     *
     * @return UserContractorEntity|null
     * @throws NotFoundHttpException
     */
    protected function findUserContractorEntity($id)
    {
        $user = Yii::$app->user;
        if (($model = UserContractorEntity::findOne(['id' => $id, 'user_id' => $user->id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Юр. лицо не найдено');
    }

    protected function findUserContractorEntityPayment($id, $entity_id)
    {
        $user = Yii::$app->user;
        if (($model = UserContractorPayment::findOne(['id' => $id, 'user_id' => $user->id, 'entity_id' => $entity_id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Форма оплаты не найдена');
    }

    protected function findUserContractorPersonPayment($id, $person_id)
    {
        $user = Yii::$app->user;
        if (($model = UserContractorPayment::findOne(['id' => $id, 'user_id' => $user->id, 'person_id' => $person_id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Форма оплаты не найдена');
    }

    /**
     * @param $id
     *
     * @return UserContractorPerson|null
     * @throws NotFoundHttpException
     */
    protected function findUserContractorPerson($id)
    {
        $user = Yii::$app->user;
        if (($model = UserContractorPerson::findOne(['id' => $id, 'user_id' => $user->id,])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Частное лицо не найдено');
    }
}
