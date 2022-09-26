<?php

use yii\db\Migration;

/**
 * Class m201117_133649_chat
 */
class m201117_133649_chat extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('chat', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->null(),
        ]);

        $this->execute("CREATE TYPE chatMessageStatusType AS ENUM ('send', 'read', 'delete')");

        $this->createTable('chat_message', [
            'id'                => $this->primaryKey(),
            'chat_id'           => $this->integer()->notNull(),
            'replay_id'         => $this->integer()->null(),
            'admin_user_id'      => $this->integer()->null(),
            'message'           => $this->text()->notNull(),
            'status'            => "chatMessageStatusType",
            'created_at'        => $this->integer(),
            'updated_at'        => $this->integer()->null(),
            'deleted_at'        => $this->integer()->null(),
        ]);

        $this->addForeignKey("fk-message-chat-to_chat_id-chat_id", "chat_message", 'chat_id', 'chat', 'id', 'CASCADE');
        $this->addForeignKey("fk-message-chat-replay_message_id-message_id", "chat_message", 'replay_id', 'chat_message', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("chat");
        $this->dropTable("chat_message");
    }
}
