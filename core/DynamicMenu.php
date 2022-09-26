<?php

namespace core;


use common\models\Menu;
use yii\helpers\VarDumper;
use yii\web\UrlManager;

class DynamicMenu implements DynamicMenuInterface
{
    private function _roots()
    {
        $root = Menu::find()->where(['active' => true, 'visible' => true])->orderBy('created_at')->roots()->one();
        if (is_null($root)) {
            return [];
        }
        return $root->children()->where(['lvl' => ($root->lvl + 1), 'active' => true, 'visible' => true])->all();
    }

    public function items()
    {
        return $this->_roots();
    }

    public function linksAsArray($linkOptions, UrlManager $urlManager)
    {
        $items = [];
        /** @var Menu $item */
        foreach ($this->_roots() as $item) {
            $items[] = [
                'label' => $item->name,
                'url' => $urlManager->createUrl($item->alias),
                'linkOptions' => $linkOptions,
            ];
        }
        return $items;
    }
}