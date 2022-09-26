<?php

namespace services;


use common\models\FakeTagModel;
use common\models\Tag;
use yii\helpers\VarDumper;


/**
 * Class TagTreeService
 * @package services
 *
 *
 *
 */
class TagTreeService extends BaseService
{

    private $treeService;

    public function __construct(TreeService $treeService, array $config = [])
    {
        $this->treeService = $treeService;
        parent::__construct($config);
    }

    /**
     * Сщздает одномерное дерево, где корневой элемент передается в параметре.
     *
     * @param FakeTagModel $root
     */
    public function createTreeFromArray(FakeTagModel $root)
    {
        $tags = FakeTagModel::find()->filterWhere(['NOT IN', 'id', [$root->id]])->all();

        $this->toRoot($root);

        $index = 1;
        $lvl = $root->lvl + 1;

        $root->lft = $index;
        /** @var FakeTagModel $tag */
        foreach ($tags as $tag) {
            $tag->lft = ++ $index;
            $tag->rgt = ++ $index;
            $tag->root = $root->id;
            $tag->lvl = $lvl;
            $tag->save();
        }
        $root->rgt = ++ $index;
        $root->save();
    }

    public function replaceNode(FakeTagModel $node, FakeTagModel $targetNode)
    {
        // 1)
        $oldLvl = $node->lvl;
        $oldLft = $node->lft;
        $oldRgt = $node->rgt;

        $node->lft = $targetNode->rgt;
        $node->lvl = $targetNode->lvl +1;

        $lvlDiff = $node->lvl - $oldLvl;

        $childs = FakeTagModel::find()->where(['>', 'lft', $oldLft])->andWhere(['<', 'rgt', $oldRgt])->all();

        $count = $this->updateIndexes($node, $childs, $lvlDiff);

        $node->save();

        $targetNode->rgt = ++ $node->rgt;
        $targetNode->save();

        // 2)
        $nodes = FakeTagModel::find()->where(['>', 'lft', $targetNode->rgt])->all();

        foreach ($nodes as $_node) {
            $_node->lft += $count * 2;
            $_node->rgt += $count * 2;
            $_node->save();
        }

//        VarDumper::dump([
//            $node, $targetNode
//        ], 4, 1);exit;
    }

    /**
     * При перемещении узла пересчитать атрибуты его потомков
     * @param FakeTagModel $parentNode
     * @param $childs
     * @param int $levelDifference
     * @return int
     */
    public function updateIndexes(FakeTagModel $parentNode, $childs, $levelDifference = 0)
    {
        $index = $parentNode->lft;

        $c = 1;

        /** @var FakeTagModel $child */
        foreach ($childs as $child) {
            $c ++;
            $child->lft = ++ $index;
            $child->rgt = ++ $index;
            $child->lvl += $levelDifference;
            $child->save();
        }
        $parentNode->rgt = ++ $index;
        return $c;
    }

    public function toRoot(FakeTagModel $node)
    {
        $node->lvl = 0;
        $node->root = $node->id;
    }

}