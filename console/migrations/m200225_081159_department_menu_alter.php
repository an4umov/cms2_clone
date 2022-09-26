<?php

use \common\models\DepartmentMenu;
use \common\models\DepartmentModel;
use yii\db\Migration;

/**
 * Class m200225_081159_department_menu_alter
 */
class m200225_081159_department_menu_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-department_menu-department_id', DepartmentMenu::tableName());

        $this->renameColumn(DepartmentMenu::tableName(), 'department_id', 'department_model_id');
        $this->alterColumn(DepartmentMenu::tableName(), 'department_model_id', $this->integer()->null());

        DepartmentMenu::updateAll(['department_model_id' => null,]);

        $this->addForeignKey(
            'fk-department_menu-department_model_id',
            DepartmentMenu::tableName(),
            'department_model_id',
            DepartmentModel::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200225_081159_department_menu_alter cannot be reverted.\n";

        return false;
    }
}
