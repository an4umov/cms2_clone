<?php

use yii\db\Migration;

/**
 * Class m190716_094150_catalog_tree_setting
 */
class m190716_094150_catalog_tree_setting extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('catalog_tree_setting', [
            'id' => $this->primaryKey(),
            'row_count_desktop' => $this->tinyInteger()->notNull(),
            'row_count_laptop' => $this->tinyInteger()->notNull(),
            'row_count_mobile' => $this->tinyInteger()->notNull(),
            'header_font_size' => $this->tinyInteger()->notNull(),
            'grid_height' => $this->tinyInteger()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('catalog_tree_setting');
    }
}
