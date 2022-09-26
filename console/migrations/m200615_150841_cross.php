<?php

use yii\db\Migration;

/**
 * Class m200615_150841_cross
 */
class m200615_150841_cross extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cross', [
            'id' => $this->primaryKey(),
            'line' => $this->integer(),
            'superarticle' => $this->string(150),
            'brand_code' => $this->string(11),
            'brand_name' => $this->string(150),
            'group_code' => $this->string(11),
            'group_name' => $this->string(150),
            'article' => $this->string(25),
            'article_name' => $this->string(150),
            'comment' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cross');
    }
}
