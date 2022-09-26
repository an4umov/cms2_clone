<?php

namespace frontend\widgets\dynamic;


use services\MaterialService;
use yii\base\Widget;

class LastNewsWidget extends Widget
{
    private $materialService;

    public function __construct(MaterialService $materialService, array $config = [])
    {
        $this->materialService = $materialService;
        parent::__construct($config);
    }

    public function run()
    {
        $lastNews = $this->materialService->lastNews();

        return $this->render('last-news', [
            'news' => $lastNews
        ]);
    }
}