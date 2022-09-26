<?php

namespace services;


use yii\base\Component;
use yii\web\UploadedFile;
use Yii;

abstract class BaseService extends Component
{
    /** @var FileService */
    protected $fileService;

    public function addImage(UploadedFile $uploadedFile)
    {
        if (is_null($this->fileService)) {
            return false;
        }
        return $this->fileService->uploadFile($uploadedFile);
    }

    /** @var array  */
    protected $errors = [];

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $error
     * @param null $key
     */
    protected function setError($error, $key = null)
    {
        Yii::error($error);
        if (!is_null($key)) {
            $this->errors[$key] = $error;
        } else {
            $this->errors[] = $error;
        }
    }

    /**
     * @param $error
     * @return bool
     */
    public function issetError($error)
    {
        return (array_key_exists($error, $this->errors) || in_array($error, $this->errors));
    }
}