<?php

namespace frontend\controllers;

use common\components\helpers\ContentHelper;
use common\components\helpers\FormHelper;
use common\models\Form;
use common\models\FormField;
use common\models\ReferenceValue;
use frontend\models\SendNotFoundForm;
use frontend\models\SendForm;
use \Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FormController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'render' => ['GET',],
                    'send' => ['POST',],
                ],
            ],
        ];
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function actionRender(int $id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response['ok'] = false;

//        $id = (int) Yii::$app->request->get('id', '');
        $key = (string) Yii::$app->request->get('key', '');

        try {
            if (empty($id)) {
                throw new BadRequestHttpException('Не задан идентификатор формы');
            }

            $form = FormHelper::getFormModel($id);

            $response['html'] = FormHelper::renderForm($form, $key);
            $response['ok'] = true;
        } catch (\Exception $e) {
            Yii::$app->errorHandler->logException($e);
            $response['message'] = $e->getTraceAsString();
        }

        return $response;
    }

    public function actionSend()
    {
        $requiredMessage = '';
        $model = new SendForm();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if (!empty($post['SendForm'])) {
                $formID = $post['SendForm']['form_id'];
                if (empty($formID)) {
                    throw new BadRequestHttpException('Не указан ID формы');
                }
                if (empty($post['SendForm'][$formID])) {
                    throw new BadRequestHttpException('Неверная структура переданных данных');
                }
                $form = Form::find()->where(['id' => $formID, 'deleted_at' => null,])->one();
                if (empty($form)) {
                    throw new NotFoundHttpException('Форма не найдена или удалена');
                }

                $fields = FormField::find()->where(['form_id' => $form->id, 'deleted_at' => null,])->andWhere(['!=', 'type', FormField::TYPE_BUTTON,])->orderBy(['sort' => SORT_ASC,])->indexBy('id')->all();
                foreach ($fields as $fieldID => $field) {
                    $json = ContentHelper::getBlockJson($field);
                    $isRequired = !empty($json[FormHelper::FIELD_IS_REQUIRED]);

                    if ($field->type === FormField::TYPE_CHECKBOX) {
                        if ($isRequired && empty($post['SendForm'][$formID][$fieldID])) {
                            $requiredMessage = 'Не установлен обязательный чекбокс "'.$field->name.'"! Форма не отправлена.';
                            break;
                        }

                        $field->value = !empty($post['SendForm'][$formID][$fieldID]) ? 'Отмечено' : 'Не отмечено';
                    } else {
                        if (isset($post['SendForm'][$formID][$fieldID]) && !is_array($post['SendForm'][$formID][$fieldID])) {
                            $formFieldValue = trim($post['SendForm'][$formID][$fieldID]);

                            if ($isRequired && empty($formFieldValue)) {
                                $requiredMessage = 'Не заполнено обязательное поле "'.$field->name.'"! Форма не отправлена.';
                                break;
                            }

                            if ($field->type === FormField::TYPE_TEXTAREA || $field->type === FormField::TYPE_TEXT
                                || $field->type === FormField::TYPE_PHONE || $field->type === FormField::TYPE_EMAIL) {
                                $field->value = $formFieldValue;
                            } elseif ($field->type === FormField::TYPE_REFERENCE_ID) {
                                $referenceID = (int) !empty($json[FormHelper::FIELD_REFERENCE_ID]) ? $json[FormHelper::FIELD_REFERENCE_ID] : 0;

                                if ($referenceID && $formFieldValue) {
                                    $field->value = ReferenceValue::find()->where(['reference_id' => $referenceID, 'deleted_at' => null, 'id' => $formFieldValue,])->select(['name',])->scalar();
                                }
                            }
                        }
                    }
                } //foreach

                if ($requiredMessage) {
                    Yii::$app->session->setFlash('error', $requiredMessage);
                } else {

                    if ($model->sendEmail($form, $fields, Yii::$app->request->referrer)) {
                        Yii::$app->session->setFlash('success', $form->result ? Html::encode($form->result) : 'Форма отправлена');
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка отправки формы');
                    }
                }
            }
        } else {
            throw new BadRequestHttpException();
        }

        return $this->goBack(Yii::$app->request->referrer);
    }

    /**
     * @return Response
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionSendNotFound()
    {
        $model = new SendNotFoundForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->sendEmail()) {
                        Yii::$app->session->setFlash('success', 'Вопрос отправлен');
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка отправки вопроса');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка валидации формы: '.print_r($model->getErrors(), true));
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка отправки вопроса: '.print_r($model->getErrors(), true));
            }
        } else {
            throw new BadRequestHttpException();
        }

        return $this->goHome();
    }
}