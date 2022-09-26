<?php

use yii\db\Migration;

/**
 * Handles adding link to table `info_block`.
 */
class m190719_085633_add_link_column_to_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('info_block', 'link', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('info_block', 'link');
    }
}
