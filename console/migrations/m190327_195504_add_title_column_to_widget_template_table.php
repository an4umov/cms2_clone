<?php

use yii\db\Migration;

/**
 * Handles adding title to table `widget_template`.
 */
class m190327_195504_add_title_column_to_widget_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('widget_template', 'title', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('widget_template', 'title');
    }
}
