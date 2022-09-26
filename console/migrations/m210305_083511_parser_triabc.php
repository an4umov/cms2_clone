<?php

use yii\db\Migration;

/**
 * Class m210305_083511_parser_triabc
 */
class m210305_083511_parser_triabc extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_triabc', [
            'id' => $this->primaryKey(),
            'article' => $this->string(255)->notNull(),
            'article_our' => $this->string(255)->notNull(),
            'brand' => $this->string(255),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'breadcrumbs' => $this->text(),
            'url' => $this->text()->notNull(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('parser_triabc');
    }
}
