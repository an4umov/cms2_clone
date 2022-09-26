<?php

namespace backend\components\widgets;

use common\components\helpers\CatalogHelper;
use common\models\Articles;
use common\models\BlockField;
use common\models\Catalog;
use common\models\FullPrice;
use frontend\models\search\ArticleItemSearch;
use frontend\models\search\CatalogListSearch;
use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class ImageGalleryWidget extends Widget
{
    /** @var string */
    public $initdir;
    /** @var string */
    public $dir;
    /** @var string */
    public $name;
    /** @var string */
    public $label;
    /** @var string */
    public $filename;
    /** @var string */
    public $filepath;

    public function init()
    {
        parent::init();

        if (empty($this->initdir)) {
            throw new NotFoundHttpException('Отсутствует начальная директория');
        }
        if (empty($this->dir)) {
            throw new NotFoundHttpException('Отсутствует директория');
        }
    }

    public function run()
    {

        return $this->render('image_gallery', [
            'id' => $this->id,
            'initdir' => $this->initdir,
            'dir' => $this->dir,
            'name' => $this->name,
            'label' => $this->label,
            'filename' => $this->filename,
            'filepath' => $this->filepath,
        ]);
    }
}
