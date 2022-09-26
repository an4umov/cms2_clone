<?php

namespace console\controllers;


use common\models\FakeTagModel;
use services\TagTreeService;
use yii\base\Module;
use yii\console\Controller;

class TreeTagsController extends Controller
{
    private $tagTreeService;

    public function __construct(string $id, Module $module, TagTreeService $tagTreeService, array $config = [])
    {
        $this->tagTreeService = $tagTreeService;
        parent::__construct($id, $module, $config);
    }

    public function actionCreateTree()
    {
        $root = new FakeTagModel();
        $root->name = "LR";
        $root->lft = 1;
        $root->rgt = 1;
        $root->lvl = 0;
        $root->icon_type = 1;
        $root->save();

        $this->tagTreeService->createTreeFromArray($root);

    }
}