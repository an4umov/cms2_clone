<?php


namespace backend\controllers;


use backend\models\TagSelectParentForm;
use common\models\Menu;
use common\models\Tag;
use Exception;
use kartik\tree\models\Tree;
use kartik\tree\Module;
use kartik\tree\TreeSecurity;
use kartik\tree\TreeView;
use Yii;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Session;

class NodeController extends \kartik\tree\controllers\NodeController
{
    const DEFAULT_MAX_LEVEL = 5;

    public $maxLevelMenu;
    public $maxLevelTag;

    public function init()
    {
        parent::init();
        
        $this->maxLevelMenu = Yii::$app->params['max-menu-level'] ?? Menu::MAX_LEVEL;
        $this->maxLevelTag = Yii::$app->params['max-tag-level'] ?? Tag::MAX_LEVEL;
    }

    /**
     * @param $treeClass
     * @return int
     */
    protected function getMaxLevel($treeClass)
    {
        $maxLevel = self::DEFAULT_MAX_LEVEL;
        if ($treeClass === Menu::class) {
            $maxLevel = $this->maxLevelMenu;
        } else if ($treeClass === Tag::class) {
            $maxLevel = $this->maxLevelTag;;
        }

        return $maxLevel;
    }

    public function actionSave()
    {
        /**
         * @var Tree $parent
         * @var Session $session
         */
        if (Yii::$app->has('session')) {
            $session = Yii::$app->session;
        }
        $post = Yii::$app->request->post();
        static::checkValidRequest(false, !isset($post['treeNodeModify']));
        $data = static::getPostData();
        $parentKey = ArrayHelper::getValue($data, 'parentKey', null);
        $currUrl = ArrayHelper::getValue($data, 'currUrl', '');
        $treeClass = TreeSecurity::getModelClass($data);

        // if class instance of Tag and isset paren ID? move to parent ID
//        if ($treeClass === Tag::class) {
//            $tsf = new TagSelectParentForm();
//            $tsf->load($post);
//            if ($parentKey != TreeView::ROOT_KEY && $parentKey != $tsf->parent_id) {
//                $parent = $treeClass::findOne($tsf->parent_id);
//                /** @var Tag $node */
//                $node = $treeClass::findOne($data['Tag']['id']);
//                if (!is_null($node) && !is_null($parent)) {
//                    $node->appendTo($parent);
//                    $parentKey = $tsf->parent_id;
//                }
//            }
//        }



        $maxLevel = $this->getMaxLevel($treeClass);

        if ($parentKey == TreeView::ROOT_KEY) {
            return parent::actionSave();
        } else {
            if (! empty($parentKey)) {
                $parent = $treeClass::findOne($parentKey);

                /**
                 * если уровень родителя равен МАКСИМАЛЬНО_РАЗЕШЕННЫЙ_УРОВЕНЬ - 1
                 * редиректим назад
                 */
                if ( (! is_null($parent)) && ((int)$parent->lvl >= ($maxLevel - 1)) ) {
                    $session->setFlash('error', "Превышен резрешенный уровень вложенности");
                    return $this->redirect($currUrl);
                }
            }

            return parent::actionSave();
        }
    }

    public function actionMove()
    {
        /**
         * @var Tree $parent
         * @var Session $session
         */
        static::checkValidRequest();
        $data = static::getPostData();
        $idTo = ArrayHelper::getValue($data, 'idTo', null);
        $parsedData = TreeSecurity::parseMoveData($data);
        /**
         * @var Tree $treeClass
         * @var Tree $node
         */
        $treeClass = $parsedData['out']['treeClass'];
        $nodeTitles = TreeSecurity::getNodeTitles($data);
        /**
         * @var Tree $nodeFrom
         * @var Tree $nodeTo
         */
        $nodeTo = $treeClass::findOne($idTo);
        $errorMsg = "Превышен резрешенный уровень вложенности";
        $maxLevel = $this->getMaxLevel($treeClass);
        $callback = function () use ($nodeTo, $maxLevel) {
            /**
             * если уровень родителя равен МАКСИМАЛЬНО_РАЗЕШЕННЫЙ_УРОВЕНЬ - 1
             * редиректим назад
             */
            if ( (! is_null($nodeTo)) && ((int)$nodeTo->lvl >= ($maxLevel - 1)) ) {
                return false;
            }
            return parent::actionMove();
        };
        return self::process($callback, $errorMsg, Yii::t('kvtree', 'The {node} was moved successfully.', $nodeTitles));
        
    }
}