<?php
namespace  backend\behaviors;

use backend\models\TagSelectParentForm;
use common\models\FakeTagModel;
use common\models\Tag;
use services\TagTreeService;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

class TreeMoveBehavior extends Behavior
{
    const ERROR_TREE_MOVE_ERROR = 'tree_move_error';

    private $tagTreeService;

    public function __construct(TagTreeService $tagTreeService, array $config = [])
    {
        $this->tagTreeService = $tagTreeService;
        parent::__construct($config);
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'setParent',
            ActiveRecord::EVENT_AFTER_UPDATE => 'changeParent',
        ];
    }

    public function changeParent($event)
    {
        $post = Yii::$app->request->post();
        $parentForm = new TagSelectParentForm();

        if ($parentForm->load($post) && $parentForm->validate()) {
            if ('' !== $parentForm->parent_id) {

                $node = FakeTagModel::find()->where(['id' => $event->sender->id])->one();
                $toNode = FakeTagModel::find()->where(['id' => $parentForm->parent_id])->one();

                if (!is_null($toNode)) {
                    $this->tagTreeService->replaceNode($node, $toNode);
                }
            }
        }
    }


    public function setParent($event)
    {
        $post = Yii::$app->request->post();
        $parentForm = new TagSelectParentForm();

        if ($parentForm->load($post) && $parentForm->validate()) {
            if ('' !== $parentForm->parent_id) {
                $node = Tag::findOne($event->sender->id);
                $toNode = Tag::findOne($parentForm->parent_id);
                if (!is_null($toNode)) {
                    $node->appendTo($toNode);
                }
            }
        }
    }

}