<?php

use yii\db\Migration;

/**
 * Class m190913_080415_content
 */
class m190913_080415_content extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE contentType AS ENUM ('page','article','news')");
        $this->createTable('content', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'type' => "contentType",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->createIndex('content-type-idx', 'content', 'type');

        $this->createTable('content_block', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(11)->notNull(),
            'block_id' => $this->integer(11)->notNull(),
            'sort' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-content_block-content_id',
            'content_block',
            'content_id',
            'content',
            'id',
            'NO ACTION'
        );
        $this->addForeignKey(
            'fk-content_block-block_id',
            'content_block',
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
        $this->execute('DROP TYPE contentType CASCADE');
        $this->execute('DROP TABLE content CASCADE');
        $this->execute('DROP TABLE content_block CASCADE');
    }
}
