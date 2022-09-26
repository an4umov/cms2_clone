<?php

use yii\db\Migration;

/**
 * Handles adding sort to table `tag`.
 */
class m190612_190232_add_sort_column_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tag', 'sort', $this->smallInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tag', 'sort');
    }
}
