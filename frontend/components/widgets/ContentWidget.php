<?php

namespace frontend\components\widgets;

use common\components\helpers\DepartmentHelper;
use common\models\Content;
use common\models\Department;
use \common\components\helpers\ContentHelper;
use yii\base\Widget;

class ContentWidget extends Widget
{
    /** @var string */
    public $shop;
    /** @var Department */
    public $department;
    /** @var Content */
    public $model;
    /** @var bool */
    public $isPage;
    /** @var integer */
    public $custom_tag_id;

    public function init()
    {
        parent::init();

        $this->isPage = is_null($this->isPage) ? false : $this->isPage;
        $this->custom_tag_id = is_null($this->custom_tag_id) ? 0 : $this->custom_tag_id;
    }

    public function run()
    {
        return ContentHelper::renderContent($this->model, $this->isPage, $this->department ? $this->department : ($this->shop ? DepartmentHelper::getDepartmentByUrl($this->shop) : null), $this->custom_tag_id);
    }
}
