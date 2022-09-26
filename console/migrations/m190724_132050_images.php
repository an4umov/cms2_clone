<?php

use yii\db\Migration;

/**
 * Class m190724_132050_images
 */
class m190724_132050_images extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('images', [
            'id' => $this->primaryKey(),
            'url' => $this->string(255)->notNull(),
            'order' => $this->integer()->notNull(),
            'article' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('images-article-idx', 'images', 'article');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('images');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190724_132050_images cannot be reverted.\n";

        return false;
    }
    */
}
