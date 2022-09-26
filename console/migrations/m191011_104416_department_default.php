<?php

use yii\db\Migration;

/**
 * Class m191011_104416_department_default
 */
class m191011_104416_department_default extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\DepartmentModel::tableName(), 'default_title', $this->string());
        $this->addColumn(\common\models\DepartmentMenu::tableName(), 'default_title', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\DepartmentModel::tableName(), 'default_title');
        $this->dropColumn(\common\models\DepartmentMenu::tableName(), 'default_title');
    }
}
