<?php

use yii\db\Migration;

/**
 * Class m210312_105432_parser_daliavto
 */
class m210312_105432_parser_daliavto extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_daliavto', [
            'id' => $this->primaryKey(),
            'article' => $this->string(255)->notNull(),
            'article_our' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
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
        $this->dropTable('parser_daliavto');
    }
}
