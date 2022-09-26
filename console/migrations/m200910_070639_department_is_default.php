<?php

use yii\db\Migration;

/**
 * Class m200910_070639_department_is_default
 */
class m200910_070639_department_is_default extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Department::tableName(), 'is_default', $this->boolean()->defaultValue(false)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Department::tableName(), 'is_default');
    }
}
