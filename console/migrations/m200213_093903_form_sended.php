<?php

use yii\db\Migration;

/**
 * Class m200213_093903_form_sended
 */
class m200213_093903_form_sended extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('form_sended', [
            'id' => $this->primaryKey(),
            'form_id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->null(),
            'page' => $this->string(256)->notNull(),
            'emails' => $this->string(256)->notNull(),
            'data' => $this->text()->notNull()->comment('JSON'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-form_sended-form_id',
            'form_sended',
            'form_id',
            'form',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-form_sended-form_id', 'form_sended');
        $this->dropTable('form_sended');
    }
}
