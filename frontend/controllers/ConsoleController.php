<?php

namespace frontend\controllers;

use common\components\helpers\CatalogHelper;
use common\components\helpers\ConsoleHelper;
use vova07\console\ConsoleRunner;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class ConsoleController extends Controller
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
                    'index' => ['GET',],
                    'catalog' => ['GET',],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionCatalog()
    {
        set_time_limit(0);

        $messages = ConsoleHelper::migrateCatalog('', false);

        return $this->render('catalog', ['messages' => $messages,]);
    }

    public function actionWebhook()
    {
        $this->layout = 'bootstrap';

        if (!Yii::$app->request->isGet) {
            throw new BadRequestHttpException('Неверный запрос');
        }

        $key = Yii::$app->request->get('k', '');

        if (empty($key)) {
            throw new BadRequestHttpException('Отстутсвует параметр');
        }

        switch ($key) {
            case ConsoleHelper::WEBHOOK_KEY_CONTRACTOR_1C:
                $result = ConsoleHelper::processPlanFixHandbooks(false);
                break;
            default:
                throw new BadRequestHttpException('Неверный параметр');
                break;
        }

        return $this->render('webhook', ['result' => $result,]);
    }

    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionCatalogUpdate()
    {
        $get = \Yii::$app->request->get();
        $key = $get['key'] ?? '';
        $salt = $get['salt'] ?? '';

        if (CatalogHelper::checkSalt($salt)) {
            if ($key) {
                unset($get['key']);

                $isChanged = CatalogHelper::updateFullPriceRow($key, $get);
                if ($isChanged) {
                    $message = 'Запись с ключом '.$key.' успешно обновлена';
                } else {
                    $message = 'Ошибка обновления записи с ключом '.$key;
                }
            } else {
                $message = 'Ключ отсутствует';
            }
        } else {
            $message = 'Отсутствует обязательный параметр';
        }

        return $this->render('catalog-update', ['message' => $message,]);
    }

}