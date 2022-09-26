<?php

namespace frontend\controllers;


use common\models\Material;
use common\models\Menu;
use common\models\Page;
use core\ContentFilter;
use yii\base\Module;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class Content2Controller extends Controller
{

    private $contentFilter;

    public function __construct(string $id, Module $module, ContentFilter $filter, array $config = [])
    {
        $this->contentFilter = $filter;
        parent::__construct($id, $module, $config);
    }

    public function actionMaterial($alias, $target = null)
    {
        //throw new NotFoundHttpException('Страница не найдена.');
        $material = Material::findOne(['alias' => $alias]);

        if (is_null($material)) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        $content = $this->contentFilter->filter($material->content);
        $material->content = $content;
        return $this->render('material', [
            'material' => $material
        ]);
    }


    public function actionMenuPage($alias, $target = null)
    {
        $page = Page::find()->where(['alias' => $alias])->one();
       return $this->render('page', [
            'model' => $page
       ]);
    }
}