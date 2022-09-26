<?php

use yii\db\Migration;

/**
 * Handles adding content to table `menu`.
 */
class m190411_204535_add_content_column_to_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('menu', 'content', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('menu', 'content');
    }
}
