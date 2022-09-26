<?php

use yii\db\Migration;

/**
 * Class m200401_075649_special_tables
 */
class m200401_075649_special_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reclama_status', [
            'id' => $this->primaryKey(),
            'code' => $this->string(9)->notNull(),
            'name' => $this->string(150)->notNull(),
            'type' => $this->string(15)->notNull(),
            'color' => $this->string(7),
            'description' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('special_offers', [
            'id' => $this->primaryKey(),
            'article_number' => $this->string(25)->notNull(),
            'product_code' => $this->string(30)->notNull(),
            'title' => $this->string(50),
            'product_name' => $this->string(100),
            'offer_type' => $this->string(15)->notNull(),
            'offer_name' => $this->string(150)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('reclama_status');
        $this->dropTable('special_offers');
    }
}
