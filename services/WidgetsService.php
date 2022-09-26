<?php

namespace services;


use backend\models\Template;

class WidgetsService extends BaseService
{
    private $viewPath;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->viewPath = \Yii::getAlias("@backend") . "/views/widget-templates";
    }

    public function templatesList()
    {
        $list = [];
        $templates = Template::findAll(['active' => 1]);
        foreach ($templates as $template) {
            $list[$template->alias] = $template->toArray();
        }
        return $list;
    }
}