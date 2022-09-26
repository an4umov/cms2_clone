<?php

namespace frontend\widgets\dynamic;

use core\models\Gallery;
use services\gallery\GalleryInterface;
use yii\helpers\VarDumper;

class GalleryWidget extends \yii\base\Widget
{
    public $id;
    private $galleryService;
    /** @var \common\models\Gallery */
    private $gallery;

    public function __construct(GalleryInterface $galleryService, array $config = [])
    {
        parent::__construct($config);
        $this->galleryService = $galleryService;
        $this->gallery = $this->galleryService->getById($this->id);

    }

    public function run()
    {
        if (!is_null($this->gallery)) {
            $gallery = new Gallery([
                'id' => $this->gallery->id,
                'title' => $this->gallery->title,
                'description' => $this->gallery->description,
                'images' => $this->gallery->imagesList(),
                'items' => $this->gallery->contentItems
            ]);
            return $this->render('gallery', [
                'gallery' => $gallery
            ]);
        }
    }
}