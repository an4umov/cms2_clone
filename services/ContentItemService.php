<?php


namespace services;


use common\models\ContentItem;
use common\models\File;
use Imagine\Image\Box;
use Yii;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\imagine\Image;
use yii\web\UploadedFile;

class ContentItemService extends BaseService
{
    protected $fileService;

    public function __construct(FileService $fileService, $config = [])
    {
        $this->fileService = $fileService;
        parent::__construct($config);
    }

    public function attachImage(ContentItem $contentItem): bool
    {
        $uploadedImage = UploadedFile::getInstance($contentItem, 'uploadImage');

        if ($uploadedImage) {

            /**
             * если для данного типа есть соотношение сторон (какое должно быть изобрахение)
             * то проверяем и если оно не подходит вернем ошибку
             */
            $ratio = ContentItem::getRatio($contentItem->type);
            if (! is_null($ratio)) {
                $image = Image::getImagine()->open($uploadedImage->tempName);
                $box = $image->getSize();

                $imageRatio = floatval($box->getWidth() / $box->getHeight());

                if ( ! ($imageRatio >= ($ratio - ContentItem::RATIO_ACCURACY) && $imageRatio <= ($ratio + ContentItem::RATIO_ACCURACY)) ) {
                    $this->setError(ContentItem::ERROR_INVALID_RATIO_MESSAGE, ContentItem::ERROR_INVALID_RATIO);
                    return false;
                }
            }

            try {
                $image = $this->fileService->uploadFile($uploadedImage);
                $imageModel = new File();
                $imageModel->name = basename($image);
                $imageModel->path = $image;
                $imageModel->title = basename($image);
                if ($imageModel->save()) {
                    $contentItem->link('attachedImage', $imageModel);
                    return true;
                }
            } catch (Exception $exception) {
                $this->setError($exception->getMessage());
            }
        }

        return false;
    }
}