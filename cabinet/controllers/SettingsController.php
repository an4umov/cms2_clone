<?php
namespace cabinet\controllers;

use common\components\helpers\UserHelper;
use common\models\LkMailing;
use common\models\UserContact;
use common\models\UserMailing;
use common\models\UserNotice;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Settings controller
 */
class SettingsController extends Controller
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

    public function actionIndex()
    {
        /** @var \cabinet\components\UserLk $user */
        $user = Yii::$app->user;

        /** @var \common\models\UserLk $model */
        $model = $user->getIdentity();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if (!empty($post['action'])) {
                if ($post['action'] === UserHelper::PROFILE_ACTION_CONTACT) {
                    $userContactPost = $post['UserContact'] ?? [];

                    if (!empty($userContactPost['id'])) {
                        $contactModel = $this->findUserContactModel($userContactPost['id']);
                    } else {
                        $contactModel = new UserContact();
                    }

                    $contactModel->load($post);
                    $contactModel->user_id = $user->id;
                    $phones = [];
                    foreach ($userContactPost['phones'] as $phone) {
                        $phone = trim($phone);
                        if (!empty($phone)) {
                            $phones[] = $phone;
                        }
                    }
                    $contactModel->setPhones($phones);

                    if (empty($userContactPost['is_main'])) {
                        $contactModel->is_main = false;
                    }

                    if ($contactModel->save()) {
                        if (!empty($contactModel->is_main)) {
                            UserContact::updateAll(['is_main' => false,], ['AND', ['user_id' => $user->id], ['<>', 'id', $contactModel->id,],]);
                        }

                        if (!empty($userContactPost['id'])) {
                            Yii::$app->session->setFlash('success', 'Контакт обновлен');
                        } else {
                            Yii::$app->session->setFlash('success', 'Контакт создан');
                        }
                    }
                } elseif ($post['action'] === UserHelper::PROFILE_ACTION_INFO) {
                    if ($model->load($post) && $model->save()) {
                        Yii::$app->session->setFlash('success', 'Данные обновлены');
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка обновления данных');
                    }
                }
            }
        }

        $contacts = UserContact::find()->where(['user_id' => $user->id, 'deleted_at' => null,])->orderBy(['updated_at' => SORT_DESC,])->all();
        $newContact = new UserContact();
        $newContact->initModel();

        array_push($contacts, $newContact);

        return $this->render('index', [
            'user' => $user,
            'model' => $model,
            'contacts' => $contacts,
        ]);
    }

    public function actionCheckContact()
    {
        $contact = new UserContact();

        if (Yii::$app->request->isAjax && $contact->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return \yii\widgets\ActiveForm::validate($contact);
        }

        throw new BadRequestHttpException();
    }

    public function actionDeleteContact($id)
    {
        if ($this->findUserContactModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Контакт удален');
        }

        return $this->redirect(['index']);
    }

    public function actionPhoneTemplate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['html' => UserHelper::getContactPhoneHtml(),];
    }

    public function actionSecurity()
    {
        /** @var \cabinet\components\UserLk $user */
        $user = Yii::$app->user;

        /** @var \common\models\UserLk $model */
        $model = $user->getIdentity();

        $model->setScenario("reset");

        // load post data and reset user password
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Пароль успешно обновлен');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка обновления пароля');
            }
        }

        return $this->render('security', [
            'model' => $model,
        ]);
    }

    public function actionNotice()
    {
        /** @var \cabinet\components\UserLk $user */
        $user = Yii::$app->user;

        $notice = UserNotice::findOne(['user_id' => $user->id,]);
        if (empty($notice)) {
            $notice = new UserNotice();
            $notice->initModel();
            $notice->user_id = $user->id;
        }

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $userMailingPost = $post['UserMailing'] ?? [];

            foreach ($userMailingPost as $lk_mailing_id => $postItem) {
                if (empty($postItem['id'])) {
                    $userMailingModel = new UserMailing();
                    $userMailingModel->user_id = $user->id;
                    $userMailingModel->lk_mailing_id = $lk_mailing_id;
                } else {
                    $userMailingModel = UserMailing::find()->where(['user_id' => $user->id, 'lk_mailing_id' => $lk_mailing_id, 'id' => $postItem['id'],])->one();
                    if (!$userMailingModel) {
                        continue;
                    }
                }

                $userMailingModel->email = $postItem['email'];

                if (empty($postItem['is_enabled'])) {
                    $userMailingModel->email = null;
                    $userMailingModel->is_enabled = false;
                } else {
                    if (empty($userMailingModel->email)) {
                        $userMailingModel->is_enabled = false;
                    } else {
                        $userMailingModel->is_enabled = true;
                    }
                }

                $userMailingModel->save();
            }


            // load post data and reset user password
            if ($notice->load($post)) {
                $post = $post['UserNotice'] ?? [];

                if (empty($post['is_order_received_email'])) {
                    $notice->order_received_email = null;
                    $notice->is_order_received_email = false;
                } else {
                    if (empty($notice->order_received_email)) {
                        $notice->is_order_received_email = false;
                    }
                }
                if (empty($post['is_order_received_sms'])) {
                    $notice->order_received_sms = null;
                    $notice->is_order_received_sms = false;
                } else {
                    if (empty($notice->order_received_sms)) {
                        $notice->is_order_received_sms = false;
                    }
                }
                if (empty($post['is_order_status_email'])) {
                    $notice->order_status_email = null;
                    $notice->is_order_status_email = false;
                } else {
                    if (empty($notice->order_status_email)) {
                        $notice->is_order_status_email = false;
                    }
                }
                if (empty($post['is_order_status_sms'])) {
                    $notice->order_status_sms = null;
                    $notice->is_order_status_sms = false;
                } else {
                    if (empty($notice->order_status_sms)) {
                        $notice->is_order_status_sms = false;
                    }
                }
                if (empty($post['is_balance_email'])) {
                    $notice->balance_email = null;
                    $notice->is_balance_email = false;
                } else {
                    if (empty($notice->balance_email)) {
                        $notice->is_balance_email = false;
                    }
                }
                if (empty($post['is_balance_sms'])) {
                    $notice->balance_sms = null;
                    $notice->is_balance_sms = false;
                } else {
                    if (empty($notice->balance_sms)) {
                        $notice->is_balance_sms = false;
                    }
                }

                if ($notice->save()) {
                    Yii::$app->session->setFlash('success', 'Данные обновлены');
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка обновления данных');
                }
            }
        }

        $emails = $phones = [];
        $contacts = UserContact::find()->select(['email', 'phones',])->where(['user_id' => $user->id, 'deleted_at' => null,])->all();

        if (!empty($user->getEmail())) {
            $emails[$user->getEmail()] = $user->getEmail();
        }

        if (!empty($user->getPhone())) {
            $phones[$user->getPhone()] = $user->getPhone();
        }

        foreach ($contacts as $contact) {
            if (!empty($contact->email)) {
                $emails[$contact->email] = $contact->email;
            }

            $list = $contact->getPhones();
            foreach ($list as $item) {
                if (!empty($item)) {
                    $phones[$item] = $item;
                }
            }
        }

        $userMailing = UserMailing::find()
            ->select(['id', 'email', 'is_enabled', 'lk_mailing_id',])
            ->where(['user_id' => $user->id,])
            ->indexBy('lk_mailing_id')
            ->all();

        $lkMailing = LkMailing::find()->orderBy(['sort' => SORT_ASC,])->asArray()->all();
        foreach ($lkMailing as $i => $item) {
            if (!isset($userMailing[$item['id']])) {
                $model = new UserMailing();
                $model->initModel();
            } else {
                $model = $userMailing[$item['id']];
            }

            $lkMailing[$i][UserMailing::tableName()] = $model;
        }

        return $this->render('notice', [
            'notice' => $notice,
            'emails' => $emails,
            'phones' => $phones,
            'mailing' => $lkMailing,
        ]);
    }

    protected function findUserContactModel($id)
    {
        if (($model = UserContact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Контакт не найден');
    }
}
