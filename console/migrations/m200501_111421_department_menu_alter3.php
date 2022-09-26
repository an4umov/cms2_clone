<?php

use yii\db\Migration;

/**
 * Class m200501_111421_department_menu_alter3
 */
class m200501_111421_department_menu_alter3 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(\common\models\DepartmentMenu::tableName(), 'is_show_news');
        $this->dropColumn(\common\models\DepartmentMenu::tableName(), 'is_show_articles');
        $this->dropColumn(\common\models\DepartmentMenu::tableName(), 'is_show_pages');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200501_111421_department_menu_alter3 cannot be reverted.\n";

        return false;
    }
}
