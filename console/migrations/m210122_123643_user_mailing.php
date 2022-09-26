<?php

use yii\db\Migration;

/**
 * Class m210122_123643_user_mailing
 */
class m210122_123643_user_mailing extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_mailing', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'is_enabled' => $this->boolean(),
            'email' => $this->string(100),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-user_mailing-user_id',
            'user_mailing',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->dropColumn('user_notice', 'is_news_email');
        $this->dropColumn('user_notice', 'news_email');
        $this->dropColumn('user_notice', 'is_defender_email');
        $this->dropColumn('user_notice', 'defender_email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210122_123643_user_mailing cannot be reverted.\n";

        return false;
    }
}
