<?php

namespace services\banners;


use common\models\File;
use common\models\Gallery;
use common\models\LowBanner;
use common\models\ShopBanner;
use core\dto\ModelFilesDto;
use yii\web\UploadedFile;
use services\BaseService;
use services\FileService;
use yii\helpers\VarDumper;

class BannersService extends BaseService
{
    public function __construct(FileService $fileService, array $config = [])
    {
        $this->fileService = $fileService;
        parent::__construct($config);
    }

    /**
     * @param LowBanner $banner
     * @param UploadedFile $image
     * @return bool
     */
    public function addLowBannerImage(LowBanner $banner, UploadedFile $image): bool
    {
        $this->addBannerImage($banner, $image);
    }

    /**
     * @param ShopBanner $banner
     * @param UploadedFile $image
     * @return bool
     */
    public function addShopBannerImage(ShopBanner $banner, UploadedFile $image): bool
    {
        return $this->addBannerImage($banner, $image);
    }

    /**
     * @param LowBanner | ShopBanner $banner
     * @param UploadedFile $image
     * @return bool
     */
    public function addBannerImage($banner, UploadedFile $image): bool
    {
        $image = $this->addImage($image);
        $imageModel = new File();
        $imageModel->name = basename($image);
        $imageModel->path = $image;
        $imageModel->title = basename($image);
        if ($imageModel->save()) {
            $banner->link('background', $imageModel);
        }
        return true;
    }

    public function addImage(UploadedFile $uploadedFile)
    {
        return $this->fileService->uploadFile($uploadedFile);
    }

}