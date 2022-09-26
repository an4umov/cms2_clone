<?php

use yii\db\Migration;

/**
 * Class m210625_083935_d_menu_all_products
 */
class m210625_083935_d_menu_all_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\DepartmentMenu::tableName(), 'is_all_products', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\DepartmentMenu::tableName(), 'is_all_products');
    }
}
