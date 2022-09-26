<?php

use yii\db\Migration;

/**
 * Class m201119_085555_chat_drop
 */
class m201119_085555_chat_drop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable("chat_message");
        $this->dropTable("chat");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201119_085555_chat_drop cannot be reverted.\n";

        return false;
    }
}
