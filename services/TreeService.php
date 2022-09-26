<?php

namespace services;


use backend\models\Tree;
use yii\base\InvalidArgumentException;

class TreeService extends BaseService
{
    public function expandTree($position, $treeClass = Tree::class)
    {
        if (is_null($position)) {
            throw new InvalidArgumentException("Position must not be null");
        }


    }

}