<?php

namespace backend\modules\articles\controllers;

use yii\web\Controller;

/**
 * Default controller for the `old_lr_articles_module` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
