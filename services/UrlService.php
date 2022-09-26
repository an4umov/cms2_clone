<?php


namespace services;


use common\models\Material;
use common\models\Menu;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

class UrlService extends BaseService implements UrlInterface
{

    public function parse($matches)
    {
        $type = '';

        $route = "content/menu-page";
        $url = explode('/', trim($matches[0]));
        $searchKey = array_pop($url);

        $target = Menu::findOne(['alias' => $searchKey]);

        if (is_null($target)) {
            $target = Material::findOne(['alias' => $searchKey]);
            $route = "content/material";
            if (is_null($target)) {
                return false;
            }
        }

        $isValid = true;
        if (count($url) !== 0) {
            $isValid = false;
            $nodeAlias = array_pop($url);

            while ($nodeAlias !== null) {
                $isValid = false;
                $node = Menu::findOne(['alias' => $nodeAlias]);

                if (is_null($node)) {
                    break;
                }
                if (count($url) === 0) {
                    $isValid = true;
                    break;
                }
                $parent = $node->parents(1)->all();
                $tmpUrls = $url;
                $parentAlias = array_pop($tmpUrls);
                if ($parent[0]->alias === $parentAlias) {
                    $isValid = true;
                }
                if (! $isValid) {
                    break;
                }
                $nodeAlias = array_pop($url);
            }
        }

        if ($isValid) {
            return [$route, ['alias' => $searchKey, 'target' => $target]];
        }
    }

    public function create($alias)
    {
        $node = Menu::findOne(["alias" => $alias]);

        if (! is_null($node)) {
            $ancestors = $node->ancestors()->findAll();
            $url = [];
            foreach ($ancestors as $ancestor) {
                $url[] = $ancestor->alias;
            }
            $url[] = $alias;
            return implode('/', $url);
        } else {
            $diffUrl = explode('/', trim(\Yii::$app->request->url));
            $parentAlias = array_pop($diffUrl);
            $material = Material::findOne([ "alias" => $alias ]);

            if (!is_null($material)) {
                if ($parentAlias === $material->alias) {
                    return $material->alias;
                }

                $valid = false;
                foreach ($material->menus as $parent) {
                    if ($parent->alias === $parentAlias) {
                        $valid = true;
                    }
                }

                if (!$valid) {
                    return $material->alias;
                }
                $url = [];
                foreach ( $diffUrl as $item ) {
                    if (!empty($item))
                        $url[] = $item;
                }
                $url[] = $parentAlias;
                $url[] = $material->alias;
                return implode('/', $url);
            }
        }
        return false;
    }

}