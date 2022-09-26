<?php

use yii\db\Migration;

/**
 * Handles adding sort to table `content_item`.
 */
class m190514_074410_add_sort_column_to_content_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('content_item', 'sort', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('content_item', 'sort');
    }
}
