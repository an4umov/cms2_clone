<?php

use yii\db\Migration;

/**
 * Class m220615_084040_content_tree
 */
class m220615_084040_content_tree extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE contentTreeType AS ENUM ('news', 'articles', 'pages')");

        $this->createTable('content_tree', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11)->null(),
            'type' => 'contentTreeType',
            'name' => $this->string()->notNull(),
            'description' => $this->text(),
            'sort' => $this->integer(11),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('content_tree_content', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(11)->notNull(),
            'content_tree_id' => $this->integer(11)->notNull(),
            'sort' => $this->integer(11),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-content_tree_content-content_id',
            'content_tree_content',
            'content_id',
            'content',
            'id',
            'NO ACTION'
        );

        $this->addForeignKey(
            'fk-content_tree_content-content_tree_id',
            'content_tree_content',
            'content_tree_id',
            'content_tree',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE contentTreeType CASCADE');
        $this->dropTable('content_tree');
        $this->dropTable('content_tree_content');
    }
}
