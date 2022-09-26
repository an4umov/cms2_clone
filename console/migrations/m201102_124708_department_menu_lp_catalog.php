<?php

use common\models\DepartmentMenu;
use yii\db\Migration;

/**
 * Class m201102_124708_department_menu_lp_catalog
 */
class m201102_124708_department_menu_lp_catalog extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(DepartmentMenu::tableName(), 'landing_page_catalog', $this->string(25));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(DepartmentMenu::tableName(), 'landing_page_catalog');
    }
}
