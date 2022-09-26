<?php

use yii\db\Migration;

/**
 * Class m200605_104031_article_recomend
 */
class m200605_104031_article_recomend extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article_recomend', [
            'id' => $this->primaryKey(),
            'number' => $this->string(64)->notNull(),
            'recomendation' => $this->text(),
            'articles' => $this->string(128)->notNull(),
            'comment' => $this->text(),
            'color' => $this->string(25)->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('article_recomend-number-idx', 'article_recomend', 'number');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('article_recomend-number-idx', 'article_recomend');
        $this->dropTable('article_recomend');
    }
}
