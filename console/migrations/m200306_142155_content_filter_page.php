<?php

use yii\db\Migration;

/**
 * Class m200306_142155_content_filter_page
 */
class m200306_142155_content_filter_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE contentFilterPageType AS ENUM ('department','department_model','department_menu')");
        $this->createTable('content_filter_page', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(11)->notNull(),
            'type' => "contentFilterPageType",
            'department_content_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-content_filter_page-content_id',
            'content_filter_page',
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
        $this->execute('DROP TABLE content_filter_page CASCADE');
        $this->execute('DROP TYPE contentFilterPageType CASCADE');
    }
}
