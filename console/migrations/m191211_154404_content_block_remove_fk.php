<?php

use yii\db\Migration;

/**
 * Class m191211_154404_content_block_remove_fk
 */
class m191211_154404_content_block_remove_fk extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-content_block-block_id',
            'content_block'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191211_154404_content_block_remove_fk cannot be reverted.\n";

        return false;
    }
}
