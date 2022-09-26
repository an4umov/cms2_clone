<?php

namespace frontend\widgets\dynamic;


use common\models\LowBanner;
use services\banners\BannersService;
use yii\base\Widget;

class LowBannerWidget extends Widget
{
    public $id;
    private $service;
    /** @var \common\models\LowBanner */
    private $banner;

    public function __construct(BannersService $service, array $config = [])
    {
        parent::__construct($config);
        $this->service = $service;
        $this->banner = LowBanner::find()->where(['id' => $this->id])->one();
    }

    public function run()
    {
        if (!is_null($this->banner)) {
            return $this->render('low-banner', [
                'banner' => $this->banner
            ]);
        }
    }
}