<?php

namespace services\gallery;

use core\dto\ModelFilesDto;
use yii\web\UploadedFile;
use \common\models\Gallery;

interface GalleryInterface
{
    // ф-и под вопросом
//    public function create();
//    public function update();
//    public function delete();
    /**
     * @param Gallery $gallery
     * @param \yii\web\UploadedFile[] $files
     * @return mixed
     */
    public function addImages(Gallery $gallery, $files = []) : bool;

    /**
     * @param UploadedFile $uploadedFile
     * @return mixed
     */
    public function addImage(UploadedFile $uploadedFile);

    public function getById($id);
}