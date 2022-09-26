<?php

use yii\db\Migration;

/**
 * Handles adding parent to table `widget_template`.
 */
class m190216_120708_add_parent_column_to_widget_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('widget_template', 'parent', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('widget_template', 'parent');
    }
}
