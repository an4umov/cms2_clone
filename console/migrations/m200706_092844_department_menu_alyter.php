<?php

use yii\db\Migration;

/**
 * Class m200706_092844_department_menu_alyter
 */
class m200706_092844_department_menu_alyter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(\common\models\DepartmentMenu::tableName(), 'department_model_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
