<?php

use yii\db\Migration;

/**
 * Class m190710_171206_external_tables
 */
class m190710_171206_external_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'number' => $this->string(25)->notNull(),
            'name' => $this->string(250)->notNull(),
            'description' => $this->text(),
            'title' => $this->string(100),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('articles-number-idx', 'articles', 'number');

        $this->createTable('full_price', [
            'id' => $this->primaryKey(),
            'price_list_code' => $this->string(12)->null(),
            'partner' => $this->string(100)->null(),
            'article_number' => $this->string(25)->null(),
            'product_code' => $this->string(30)->null(),
            'manufacturer' => $this->string(50)->null(),
            'quality' => $this->string(100)->null(),
            'product_name' => $this->string(150)->null(),
            'price' => $this->decimal(10, 2)->null(),
            'sale' => $this->string(150),
            'price_discount' => $this->decimal(10, 2)->null(),
            'price_opt' => $this->decimal(10, 2)->null(),
            'availability' => $this->string(5)->null(),
            'delivery_time' => $this->string(50)->null(),
            'commentary' => $this->text()->null(),
            'multiplicity' => $this->decimal(10, 0)->null(),
            'commentary2' => $this->text()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('full_price-article_number-idx', 'full_price', 'article_number');

        $this->createTable('prices', [
            'id' => $this->primaryKey(),
            'product_code' => $this->string(30)->notNull(),
            'article_number' => $this->string(25)->notNull(),
            'product_name' => $this->string(250)->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'sale' => $this->tinyInteger()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('prices-product_code-idx', 'prices', 'product_code');
        $this->createIndex('prices-article_number-idx', 'prices', 'article_number');

        $this->createTable('remnants_of_goods', [
            'id' => $this->primaryKey(),
            'product_code' => $this->string(30)->notNull(),
            'article_number' => $this->string(25)->null(),
            'product_name' => $this->string(250)->null(),
            'quantity' => $this->smallInteger()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('remnants_of_goods-product_code-idx', 'remnants_of_goods', 'product_code');
        $this->createIndex('remnants_of_goods-article_number-idx', 'remnants_of_goods', 'article_number');

        $this->createTable('replacements', [
            'id' => $this->primaryKey(),
            'type_id' => $this->string(25)->null(),
            'article_id' => $this->string(150)->null(),
            'article_number' => $this->string(25)->null(),
            'current_replacement' => $this->tinyInteger()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('replacements-article_number-idx', 'replacements', 'article_number');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('articles');
        $this->dropTable('full_price');
        $this->dropTable('prices');
        $this->dropTable('remnants_of_goods');
        $this->dropTable('replacements');
    }
}
