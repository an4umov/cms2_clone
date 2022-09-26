<?php

use yii\db\Migration;

/**
 * Class m191015_120429_department_landing
 */
class m191015_120429_department_landing extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Department::tableName(), 'landing_menu_id', $this->integer(11)->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Department::tableName(), 'landing_menu_id');
    }
}
