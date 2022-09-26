<?php

use yii\db\Migration;

/**
 * Class m191004_123517_content_filter
 */
class m191004_123517_content_filter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE contentFilterType AS ENUM ('tag','model')");
        $this->createTable('content_filter', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(11)->notNull(),
            'type' => "contentFilterType",
            'list_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-content_filter-content_id',
            'content_filter',
            'content_id',
            'content',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE content_filter CASCADE');
        $this->execute('DROP TYPE contentFilterType CASCADE');
    }
}
