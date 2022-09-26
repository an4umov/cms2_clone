<?php

namespace backend\controllers;

use amnah\yii2\user\controllers\AdminController;
use backend\models\UserInvite;
use backend\models\UserSearch;
use common\models\User;
use Yii;
use yii\helpers\VarDumper;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

/**
 * Class UserController
 * @package backend\controllers
 */
class UserController extends AdminController
{
    /**
     * @return mixed|string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $searchModel->load(Yii::$app->request->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @return array
     */
    public function actionInvite()
    {
        $inviteModel = new UserInvite();
        $inviteModel->load(Yii::$app->request->post(), '');
        $existingUsers = $inviteModel->invite();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return array_map(function (User $user) {
            return [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->profile->full_name,
            ];
        }, $existingUsers);
    }

    /**
     * Переопределяет метод родительского класса. По условию не должно быть view, поэтому
     * делаем редирект к списку.
     *
     * @param string $id
     * @return mixed|Response
     */
    public function actionView($id)
    {
        return $this->redirect('index');
    }
}
