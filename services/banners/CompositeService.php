<?php

namespace services\banners;


use common\models\Composite;
use common\models\File;
use services\BaseService;
use services\FileService;
use yii\web\UploadedFile;

class CompositeService extends BaseService
{

    public function __construct(FileService $fileService, array $config = [])
    {
        $this->fileService = $fileService;
        parent::__construct($config);
    }

    public function addImages(Composite $composite, $files = []): bool
    {
        foreach ($files as $file) {
            $image = $this->addImage($file);
            $imageModel = new File();
            $imageModel->name = basename($image);
            $imageModel->path = $image;
            $imageModel->title = basename($image);
            if ($imageModel->save()) {
                $composite->link('images', $imageModel);
            }
        }
        return true;
    }


    public function addImage(UploadedFile $uploadedFile)
    {
        return $this->fileService->uploadFile($uploadedFile);
    }
}