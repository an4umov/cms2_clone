<?php

use yii\db\Migration;

/**
 * Class m200407_080310_question_sended
 */
class m200407_080310_question_sended extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('question_sended', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->null(),
            'content_id' => $this->integer(11)->notNull(),
            'content_type' => $this->string(256)->notNull(),
            'name' => $this->string(100)->notNull(),
            'email' => $this->string(100)->notNull(),
            'comment' => $this->text()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('form_sended');
    }
}
