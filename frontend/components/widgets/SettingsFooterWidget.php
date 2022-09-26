<?php

namespace frontend\components\widgets;

use common\components\helpers\ContentHelper;
use common\models\SettingsFooter;
use yii\base\Widget;

class SettingsFooterWidget extends Widget
{
    public function run()
    {
        $blocks = SettingsFooter::find()->where(['is_active' => true,])->orderBy(['id' => SORT_ASC,])->with('items')->all();

        return $this->render('settings_footer', [
            'blocks' => $blocks,
        ]);
    }
}
