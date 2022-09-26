<?php

namespace services;

use common\models\File;
use core\dto\ModelFilesDto;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

/**
 * Class FileService
 * @package services
 */
class FileService extends BaseService
{
    const UPLOADED_FILES_PROPERTY_NAME = 'uploadedFiles';

    protected $path;
    protected $relativePath;

    public function __construct(array $config = [])
    {
        $this->relativePath = '/files';
        $this->path = Yii::getAlias('@files') . DIRECTORY_SEPARATOR;
        parent::__construct($config);
    }


    /**
     * @param Model $model
     * @return bool
     * @throws \yii\base\Exception
     */
    public function uploadModelFiles(Model $model)
    {
        $files = UploadedFile::getInstances($model, self::UPLOADED_FILES_PROPERTY_NAME);

        /** @var UploadedFile $file */
        foreach ($model->uploadedFiles as $file) {
            if (isset($file->extension)) {
                $filePath = $this->uploadFile($file);
                try {
                    if ($filePath !== false) {
                        /** @var File $fileModel */
                        $fileModel = new File();
                        $fileModel->name = basename($filePath);
                        $fileModel->description = basename($filePath);
                        $fileModel->path = $filePath;
                        $fileModel->save();
                        $model->link('files', $fileModel);
                    }
                } catch (\Exception $e) {
                    Yii::error($e->getMessage());
                }
            }
        }
        return true;
    }

    /**
     * @param UploadedFile $file
     * @return bool|string
     * @throws Exception
     */
    public function uploadFile(UploadedFile $file)
    {
        $fileName = Yii::$app->security->generateRandomString(10) . ($file->extension ? '.' . $file->extension : '');
        $filePath = $this->generatePath($fileName, $file->extension);

        if ($this->upload($file, $fileName, $filePath)) {
            return $filePath . $fileName;
        } else {
            return false;
        }

    }

    /**
     * @param UploadedFile $file
     * @param $fileName
     * @param $filePath
     * @return bool
     */
    public function upload(UploadedFile $file, $fileName, $filePath)
    {
        $targetFolderPath = $this->getFullPath($filePath);
        $this->checkDir(rtrim($targetFolderPath, DIRECTORY_SEPARATOR));
        return $file->saveAs($targetFolderPath . DIRECTORY_SEPARATOR . $fileName);
    }


    /**
     * @param $fileName
     * @param $extension
     * @return string
     */
    private function generatePath($fileName, $extension)
    {
        return '';
        $folderNameLength = 2;
        if (!empty($extension)) {
            $extension = ltrim($extension, ".") . DIRECTORY_SEPARATOR;
        }
        $hash = md5($fileName);
        return $extension . substr($hash, 0, $folderNameLength) . DIRECTORY_SEPARATOR
            . substr($hash, 2, $folderNameLength) . DIRECTORY_SEPARATOR
            . substr($hash, 4, $folderNameLength) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param $path
     * @return string
     */
    private function getFullPath($path)
    {
        return $this->path . $path;
    }

    /**
     * @param $path
     */
    private function checkDir($path)
    {
        if (! is_dir($path)) {
            try {
                mkdir($path, 755, true);
            } catch (Exception $e) {
                Yii::error($e->getMessage());
            }
        }
    }

    /**
     * @param $fileName
     * @param $extension
     * @return string
     */
    public function gen($fileName, $extension)
    {
        return $this->generatePath($fileName, $extension);
    }

    public function imagesList()
    {
        return $this->scanDir(Yii::getAlias($this->path));
    }

    public function scanDir($dir)
    {
        $list = [];
        $images = scandir(Yii::getAlias($dir));

        foreach ( $images as $image ) {
            if ($image === '.' || $image === '..') {
                continue;
            }
            if (is_dir($this->path . $image)) {
                continue;
            } else {
                $list[] = [
                    'title' => $image,
                    'thumb' => '/img' . $this->relativePath . '/' . $image,
                    'image' => '/img' . $this->relativePath . '/' . $image,
                ];
            }

        }
        return $list;
    }


    public function deleteFile($path)
    {

    }

}