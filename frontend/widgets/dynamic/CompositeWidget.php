<?php

namespace frontend\widgets\dynamic;


use common\models\Composite;
use services\banners\CompositeService;
use yii\jui\Widget;

class CompositeWidget extends Widget
{
    const TYPE_TABS = Composite::TYPE_TABS;
    const TYPE_ACCORDION = Composite::TYPE_ACCORDION;

    public $id;
    public $type;
    private $service;
    private $composite;

    public function __construct(CompositeService $service, array $config = [])
    {
        parent::__construct($config);
        $this->service = $service;
        $this->composite = Composite::find()->where(['id' => $this->id, 'type' => $this->type])->one();
    }

    public function run()
    {
        if (!is_null($this->composite)) {
            if ($this->composite->type === Composite::TYPE_ACCORDION) {
                return $this->render('shop-section-composite-accordion', [
                    'composite' => $this->composite
                ]);
            }

            if ($this->composite->type === Composite::TYPE_TABS) {
                return $this->render('shop-section-composite-tabs', [
                    'composite' => $this->composite
                ]);
            }
        }

        return null;
    }
}