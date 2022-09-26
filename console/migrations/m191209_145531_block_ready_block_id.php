<?php

use yii\db\Migration;

/**
 * Class m191209_145531_block_ready_block_id
 */
class m191209_145531_block_ready_block_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\BlockReady::tableName(), 'block_id', $this->integer(11)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\BlockReady::tableName(), 'block_id');
    }
}
