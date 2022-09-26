<?php

use yii\db\Migration;

/**
 * Class m190913_150849_content_block_field
 */
class m190913_150849_content_block_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('content_block_field', [
            'id' => $this->primaryKey(),
            'block_id' => $this->integer(11)->notNull(),
            'data' => $this->text()->notNull()->comment('JSON'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-content_block_field-block_id',
            'content_block_field',
            'block_id',
            'block',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE content_block_field CASCADE');
    }
}
