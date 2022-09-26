<?php


namespace frontend\widgets\dynamic;


use common\models\ShopBanner;
use services\banners\BannersService;
use yii\jui\Widget;
use common\models\InfoBlock;

class InfoBlockWidget extends Widget
{
    public $id;
    private $service;
    /** @var InfoBlock */
    private $banner;

    public function __construct(BannersService $service, array $config = [])
    {
        parent::__construct($config);
        $this->service = $service;
        $this->banner = InfoBlock::find()->where(['id' => $this->id])->one();

    }

    public function run()
    {
        if (!is_null($this->banner)) {
            return $this->render('info-block-' . $this->banner->type, [
                'banner' => $this->banner,
            ]);
        }
    }
}