<?php

use yii\db\Migration;

/**
 * Class m200514_061502_departments_landing_page_id
 */
class m200514_061502_departments_landing_page_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Department::tableName(), 'landing_page_id', $this->integer(11));
        $this->addColumn(\common\models\DepartmentModel::tableName(), 'landing_page_id', $this->integer(11));
        $this->addColumn(\common\models\DepartmentMenu::tableName(), 'landing_page_id', $this->integer(11));
        $this->addColumn(\common\models\DepartmentMenuTag::tableName(), 'landing_page_id', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Department::tableName(), 'landing_page_id');
        $this->dropColumn(\common\models\DepartmentModel::tableName(), 'landing_page_id');
        $this->dropColumn(\common\models\DepartmentMenu::tableName(), 'landing_page_id');
        $this->dropColumn(\common\models\DepartmentMenuTag::tableName(), 'landing_page_id');
    }
}
