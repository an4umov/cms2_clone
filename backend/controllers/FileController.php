<?php

namespace backend\controllers;


use common\models\File;
use yii\web\Controller;
use services\FileService;
use yii\base\Module;

class FileController extends Controller
{

    private $fileService;

    public function __construct(string $id, Module $module, FileService $fileService, array $config = [])
    {
        $this->fileService = $fileService;
        parent::__construct($id, $module, $config);
    }

    public function actionUpload()
    {
        return [];
    }
}