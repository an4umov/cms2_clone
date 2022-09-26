<?php

use yii\db\Migration;

/**
 * Class m210625_100407_dep_default_menu_id
 */
class m210625_100407_dep_default_menu_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Department::tableName(), 'default_menu_id', $this->integer(11)->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Department::tableName(), 'default_menu_id');
    }
}
