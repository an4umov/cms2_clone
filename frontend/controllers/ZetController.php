<?php

namespace frontend\controllers;


use common\models\FakeTagModel;
use common\models\Image;
use common\models\Material;
use common\models\Menu;
use common\models\Tag;
use services\FileService;
use services\TagTreeService;
use yii\base\Module;
use yii\helpers\VarDumper;
use yii\web\Controller;

class ZetController extends  Controller
{
    private $fileService;
    private $tagTreeService;

    public function __construct(string $id, Module $module, FileService $fileService, TagTreeService $tagTreeService, array $config = [])
    {
        $this->tagTreeService = $tagTreeService;
        $this->fileService = $fileService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $node  = FakeTagModel::findOne(120);
        $this->tagTreeService->createTreeFromArray($node);

        $node1  = FakeTagModel::findOne(93);
        $node2  = FakeTagModel::findOne(67);

        $node1  = FakeTagModel::findOne(67);
        $node2  = FakeTagModel::findOne(65);

        $this->tagTreeService->replaceNode($node1, $node2);

        exit;
    }
    public function actionTest()
    {
        $d = Menu::find()->where(['active' => true, 'visible' => true])->orderBy('created_at')->roots()->one();
        VarDumper::dump($d, 3, 1);
        exit;
    }
}