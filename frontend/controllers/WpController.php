<?php

namespace frontend\controllers;

use common\components\helpers\AppHelper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class WpController extends Controller
{

    /**
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        $posts = AppHelper::curlRequest('http://wptest.lr.ru/wp-json/wp/v2/posts');

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $posts;
        }

        return $this->render('index', [
            'posts' => $posts,
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionPost($id)
    {
        $post = AppHelper::curlRequest('http://wptest.lr.ru/wp-json/wp/v2/posts/'.$id);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $post;
        }

        return $this->render('post', [
            'post' => $post,
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionPage($page)
    {
        $url = 'http://wptest.lr.ru/wp-json/wp/v2/pages';
        if (is_numeric($page)) {
            $url .= '/'.$page;
        } else {
            $url .= '?slug='.$page;
        }

        $page = AppHelper::curlRequest($url);

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $page;
        }

        return $this->render('page', [
            'page' => $page,
        ]);
    }

    /**
     * @param array $params
     *
     * @return string
     * @throws \Exception
     */
    public function actionFilter(array $params)
    {
        return $this->renderPartial('search', [
            'data' => AppHelper::getWpSearchResult($params),
        ]);
    }
}