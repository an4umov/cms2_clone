<?php

namespace core\models;


trait HasImagesTrait
{
    public $images_list;

    public function imagesList()
    {
        $images = $this->images;
        $list = [];
        /** @var Image $image */
        foreach ($images as $image) {
            $list[] = $image->fullPath;
        }
        return $list;
    }
}