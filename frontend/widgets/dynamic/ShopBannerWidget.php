<?php

namespace frontend\widgets\dynamic;


use common\models\ShopBanner;
use services\banners\BannersService;
use yii\base\Widget;
use yii\helpers\VarDumper;

class ShopBannerWidget extends Widget
{
    public $id;
    private $service;
    /** @var \common\models\ShopBanner */
    private $banner;

    public function __construct(BannersService $service, array $config = [])
    {
        parent::__construct($config);
        $this->service = $service;
        $this->banner = ShopBanner::find()->where(['id' => $this->id])->one();

    }

    public function run()
    {
        if (!is_null($this->banner)) {
            return $this->render('shop-banner-' . $this->banner->type, [
                'banner' => $this->banner
            ]);
        }
    }
}