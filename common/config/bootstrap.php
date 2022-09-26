<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@frontendImages', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'img');
Yii::setAlias('@frontendDocs', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'docs');
Yii::setAlias('@frontendDocsWeb', '/docs');
Yii::setAlias('@backendImages', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'img');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@cabinet', dirname(dirname(__DIR__)) . '/cabinet');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@files', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'files');
Yii::setAlias('@services', dirname(dirname(__DIR__)) . '/services');
Yii::setAlias('@uploads', dirname(dirname(__DIR__)) . '/uploads');
Yii::setAlias('@core', dirname(dirname(__DIR__)) . '/core');
Yii::setAlias('@vendor', dirname(dirname(__DIR__)) . '/vendor');

$container = \Yii::$container;
$container->set(\services\gallery\GalleryInterface::class, \services\gallery\GalleryService::class);
