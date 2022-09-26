<?php

use yii\db\Migration;

/**
 * Handles adding is_main to table `material`.
 */
class m190317_194529_add_is_main_column_to_material_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('material', 'is_main', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('material', 'is_main');
    }
}
