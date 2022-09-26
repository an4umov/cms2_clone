<?php

use yii\db\Migration;

/**
 * Class m200501_080623_department_menu_alter
 */
class m200501_080623_department_menu_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn(\common\models\DepartmentMenu::tableName(), 'icon', 'image');
        $this->alterColumn(\common\models\DepartmentMenu::tableName(), 'image', $this->string(255)->null());

        \common\models\DepartmentMenu::updateAll(['image' => '',]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200501_080623_department_menu_alter cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200501_080623_department_menu_alter cannot be reverted.\n";

        return false;
    }
    */
}
