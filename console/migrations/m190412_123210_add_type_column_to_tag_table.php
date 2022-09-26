<?php

use yii\db\Migration;

/**
 * Handles adding type to table `tag`.
 */
class m190412_123210_add_type_column_to_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tag', 'type', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tag', 'type');
    }
}
