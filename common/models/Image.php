<?php

namespace common\models;

use core\FileAccessInterface;

/**
 * Class Image
 * @package common\models
 *
 * @property $fullPath string
 */
class Image extends File implements FileAccessInterface
{
    const LOCALLY_PATH = '/img/files/';

    public function getFullPath()
    {
        return self::LOCALLY_PATH . $this->path;
    }

}