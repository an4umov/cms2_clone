<?php

use yii\db\Migration;
use \common\models\DepartmentMenu;

/**
 * Class m201102_122211_department_menu_alter
 */
class m201102_122211_department_menu_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(DepartmentMenu::tableName(), 'default_title');
        $this->dropColumn(DepartmentMenu::tableName(), 'is_special');

        $this->execute("CREATE TYPE departmentMenuLandingPageType AS ENUM ('page', 'catalog')");
        $this->addColumn(DepartmentMenu::tableName(), 'landing_page_type', "departmentMenuLandingPageType");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE departmentMenuLandingPageType CASCADE');

        $this->dropColumn(\common\models\Order::tableName(), 'landing_page_type');
    }
}
