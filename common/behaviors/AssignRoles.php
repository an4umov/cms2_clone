<?php
namespace common\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class AssignRoles
 * @package common\behaviors
 */
class AssignRoles extends Behavior
{
    public $in_attribute = 'name';
    public $out_attribute = 'slug';
    public $translit = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'assign',
            ActiveRecord::EVENT_AFTER_UPDATE => 'assign'
        ];
    }

    public function assign( $event )
    {
        if (is_array($this->owner->roles)) {
            \Yii::$app->authManager->revokeAll($this->owner->id);
            foreach ($this->owner->roles as $role) {
                $authItem = \Yii::$app->authManager->getRole($role);
                \Yii::$app->authManager->assign($authItem, $this->owner->id);
            }
        }
    }
}