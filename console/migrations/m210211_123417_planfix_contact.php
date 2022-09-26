<?php

use yii\db\Migration;

/**
 * Class m210211_123417_planfix_contact
 */
class m210211_123417_planfix_contact extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE planfixContactType AS ENUM ('contact', 'company')");

        $this->createTable('planfix_contact', [
            'id' => $this->primaryKey(),
            'planfix_id' => $this->integer(11)->notNull(),
            'one_c_id' => $this->integer(11)->comment('1C'),
            'name' => $this->string(255)->notNull(),
            'midName' => $this->string(255),
            'lastName' => $this->string(255),
            'type' => "planfixContactType",

            'customData' => $this->string()->comment('JSON'),
            'phones' => $this->string()->comment('JSON'),
            'email' => $this->string(),
            'address' => $this->string(),
            'site' => $this->string(),
            'skype' => $this->string(),
            'facebook' => $this->string(),
            'telegram' => $this->string(),
            'instagram' => $this->string(),
            'vk' => $this->string(),
            'icq' => $this->string(),

            'description' => $this->text(),
            'terms' => $this->text(),
            'last_change_info' => $this->text()->comment('JSON'),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('planfix_contact-planfix_id-unq', 'planfix_contact', 'planfix_id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE planfixContactType CASCADE');
        $this->dropIndex('planfix_contact-planfix_id-unq', 'planfix_contact');
        $this->dropTable('planfix_contact');
    }
}
