<?php

namespace frontend\components\widgets;

use common\components\helpers\ContentHelper;
use yii\base\Widget;

class BreadcrumbsWidget extends Widget
{
    public $breadcrumbs = [];

    public function run()
    {
        return $this->render('breadcrumbs', [
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }
}
