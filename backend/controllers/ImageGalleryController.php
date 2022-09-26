<?php

namespace backend\controllers;

use common\components\helpers\ContentHelper;
use \yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ImageGalleryController extends Controller
{
    public function actionList()
    {
        $isDirs = $isFiles = false;
        $initdir = \Yii::$app->request->get('initdir', '');
        $dir = \Yii::$app->request->get('dir', '');
        $filepath = \Yii::$app->request->get('filepath', '');
        $isInit = (bool) \Yii::$app->request->get('init', 0);
        $data = [];

        if ($dir && $isInit && $filepath) {
            $subDir = substr($filepath, 0, strrpos($filepath, '/'));
            if (!empty($subDir)) {
                $dir .= $subDir;
            }
        }

        if ($dir) {
            $dir = FileHelper::normalizePath($dir);
            $fileOptions = ['only' => ['*.png', '*.jpg', '*.gif', '*.jpeg', '*.webp',], 'caseSensitive' => false, 'recursive' => false,];

            if (file_exists($dir)) {
                $options = ['recursive' => false,];
                $directories = FileHelper::findDirectories($dir, $options);
                sort($directories, SORT_NATURAL);

                if ($initdir !== $dir) {
                    $data[] = [
                        'name' => 'Наверх',
                        'path' => '..',
                        'initdir' => $initdir,
                        'fullPath' => $dir,
                        'webPath' => '/img/directory_up.jpg',
                        'size' => '',
                        'resolution' => '',
                        'isDir' => true,
                        'parentDir' => substr($dir, 0, strrpos($dir, DIRECTORY_SEPARATOR)),
                        'fileCount' => count(FileHelper::findFiles($dir, $fileOptions)),
                    ];
                    $isDirs = true;
                }

                foreach ($directories as $directory) {
                    $nameFicheiro = substr($directory, strrpos($directory, DIRECTORY_SEPARATOR) + 1);

                    $path = str_replace('\\', '/', FileHelper::normalizePath(str_replace($dir, '', $directory)));
                    $data[] = [
                        'name' => $nameFicheiro,
                        'path' => $path,
                        'fullPath' => $directory,
                        'initdir' => $initdir,
                        'webPath' => '/img/directory2.jpg',
                        'size' => '',
                        'resolution' => '',
                        'isDir' => true,
                        'parentDir' => '',
                        'fileCount' => count(FileHelper::findFiles($directory, $fileOptions)),
                    ];

                    $isDirs = true;
                }

                $files = FileHelper::findFiles($dir, $fileOptions);
                sort($files, SORT_NATURAL);

                foreach ($files as $file) {
                    $finf = stat($file);
                    $nameFicheiro = substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1);
                    list($finf_width, $finf_height, $finf_type, $finf_attr) = @getimagesize($file);

                    $data[] = [
                        'name' => $nameFicheiro,
                        'path' => str_replace('\\', '/', FileHelper::normalizePath(str_replace($initdir, '', $file))), //substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1),//Url::base().'/img/'.$nameFicheiro,
                        'fullPath' => '',
                        'initdir' => $initdir,
                        'webPath' => str_replace('\\', '/', '/img'.FileHelper::normalizePath(str_replace(\Yii::getAlias('@backendImages'), '', $file))), //substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1),//Url::base().'/img/'.$nameFicheiro,
                        'size' => sprintf('%1.2f', $finf['size'] / 1024).' кб',
                        'resolution' => $finf_width.'x'.$finf_height,
                        'isDir' => false,
                        'parentDir' => '',
                        'fileCount' => 0,
                    ];

                    $isFiles = true;
                }
            } else {
                throw new NotFoundHttpException('Папки '.$dir.' не существует');
            }
        } else {
            throw new NotFoundHttpException('Не указана папка поиска изображений');
        }

        return $this->renderAjax('index', [
            'data' => $data,
            'dir' => $dir,
            'initdir' => $initdir,
            'filepath' => $filepath,
            'isDirs' => $isDirs,
            'isFiles' => $isFiles,
        ]);
    }
}