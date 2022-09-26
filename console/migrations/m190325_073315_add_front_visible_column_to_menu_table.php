<?php

use yii\db\Migration;

/**
 * Handles adding front_visible to table `menu`.
 */
class m190325_073315_add_front_visible_column_to_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('menu', 'front_visible', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('menu', 'front_visible');
    }
}
