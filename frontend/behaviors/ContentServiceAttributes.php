<?php

namespace frontend\behaviors;

use common\models\Material;
use core\ContentFilter;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

class ContentServiceAttributes extends Behavior
{

    public $property;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'clean',
        ];
    }

    public function clean($event)
    {
        $this->cleanComments($event->sender);
    }

    public function cleanComments(Material $material)
    {
    }

}