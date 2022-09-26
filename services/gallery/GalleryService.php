<?php

namespace services\gallery;


use common\models\File;
use common\models\Gallery;
use core\dto\ModelFilesDto;
use yii\web\UploadedFile;
use services\BaseService;
use services\FileService;
use yii\helpers\VarDumper;

class GalleryService extends BaseService implements GalleryInterface
{

    public function __construct(FileService $fileService, array $config = [])
    {
        $this->fileService = $fileService;
        parent::__construct($config);
    }

    /**
     * @param Gallery $gallery
     * @param \yii\web\UploadedFile[] $files
     * @return mixed
     */
    public function addImages(Gallery $gallery, $files = []): bool
    {
        foreach ($files as $file) {
            $image = $this->addImage($file);
            $imageModel = new File();
            $imageModel->name = basename($image);
            $imageModel->path = $image;
            $imageModel->title = basename($image);
            if ($imageModel->save()) {
                $gallery->link('images', $imageModel);
            }
        }
        return true;
    }


    public function addImage(UploadedFile $uploadedFile)
    {
        return $this->fileService->uploadFile($uploadedFile);
    }

    /**
     * @param $id
     * @return Gallery|null
     */
    public function getById($id)
    {
        return Gallery::findOne($id);
    }
}