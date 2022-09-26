<?php

use yii\db\Migration;

/**
 * Class m191022_132939_custom_tag
 */
class m191022_132939_custom_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('custom_tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createTable('content_custom_tag', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer()->notNull(),
            'custom_tag_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-content_custom_tag-content_id',
            'content_custom_tag',
            'content_id',
            'content',
            'id',
            'NO ACTION'
        );
        $this->addForeignKey(
            'fk-content_custom_tag-custom_tag_id',
            'content_custom_tag',
            'custom_tag_id',
            'custom_tag',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE custom_tag CASCADE');
        $this->execute('DROP TABLE content_custom_tag CASCADE');
    }
}
