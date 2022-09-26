<?php

use yii\db\Migration;

/**
 * Class m191207_130429_block_ready_alter_type
 */
class m191207_130429_block_ready_alter_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn(\common\models\BlockReady::tableName(), 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191207_130429_block_ready_alter_type cannot be reverted.\n";

        return false;
    }
}
