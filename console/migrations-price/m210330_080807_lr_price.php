<?php

use yii\db\Migration;

/**
 * Class m210330_080807_lr_price
 *
 * yii migrate --migrationPath=@app/migrations-price --db=dbp
 */
class m210330_080807_lr_price extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('supplier', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'country' => $this->string(50)->notNull(),
            'language' => $this->string(50),
            'description' => $this->text(),
            'site' => $this->string(255),
            'address' => $this->text(),
            'phone' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->insert('supplier', ['title' => 'Поставщик 1', 'country' => 'Россия', 'language' => 'Русский', 'description' => 'Очень надежный поставщик', 'site' => 'http://supplier1.ru', 'address' => 'г. Москва, ул. Мира 1', 'phone' => '+79032343344', 'created_at' => time(), 'updated_at' => time(),]);
        $this->insert('supplier', ['title' => 'Поставщик 2', 'country' => 'Россия', 'language' => 'Русский', 'description' => 'Надежный поставщик', 'site' => 'http://supplier2.ru', 'address' => 'г. Самара, ул. Дружбы 13, корпус 4', 'phone' => '+792722343366', 'created_at' => time(), 'updated_at' => time(),]);
        $this->insert('supplier', ['title' => 'Поставщик 3', 'country' => 'Белоруссия', 'language' => 'Русский', 'description' => 'Не очень надежный поставщик', 'site' => 'https://supplier3.by', 'address' => 'г. Минск, ул. Доброты 34', 'phone' => '', 'created_at' => time(), 'updated_at' => time(),]);
        $this->insert('supplier', ['title' => 'Поставщик 4', 'country' => 'Китай', 'language' => 'Китайский', 'description' => 'Поставщик', 'site' => 'http://supplier4.ch', 'address' => 'г. Пекин, ул. Поднебесная, 14', 'phone' => '', 'created_at' => time(), 'updated_at' => time(),]);
        $this->insert('supplier', ['title' => 'Поставщик 5', 'country' => 'Англия', 'language' => 'Английский', 'description' => 'Очень не надежный поставщик из туманного альбиона', 'site' => 'https://supplier5.com', 'address' => 'г. Лондон, ул. Бейкер 220', 'phone' => '', 'created_at' => time(), 'updated_at' => time(),]);

        $this->createTable('unit', [
            'id' => $this->primaryKey(),
            'title' => $this->string(50)->notNull(),
            'value' => $this->string(50)->notNull(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->insert('unit', ['title' => 'Вес', 'value' => 'кг', 'description' => 'Вес', 'created_at' => time(), 'updated_at' => time(),]);
        $this->insert('unit', ['title' => 'Количество', 'value' => 'шт', 'description' => 'Количество в штуках', 'created_at' => time(), 'updated_at' => time(),]);
        $this->insert('unit', ['title' => 'Объем кубический', 'value' => 'м3', 'description' => 'Объем кубический', 'created_at' => time(), 'updated_at' => time(),]);
        $this->insert('unit', ['title' => 'Объем жидкостный', 'value' => 'мл', 'description' => 'Объем в милилитрах', 'created_at' => time(), 'updated_at' => time(),]);

        $this->createTable('price', [
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer(11)->notNull(),
            'code' => $this->string(50)->notNull(),
            'article' => $this->string(50)->notNull(),
            'name' => $this->string(200)->notNull(),
            'producer' => $this->string(20)->comment('производитель'),
            'price1' => $this->float(2),
            'price2' => $this->float(2),
            'price3' => $this->float(2),
            'price4' => $this->float(2),
            'price5' => $this->float(2),
            'count' => $this->float(2),
            'unit_id' => $this->integer(11)->notNull(),
            'description' => $this->string(200),
            'image' => $this->text(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-price-supplier_id',
            'price',
            'supplier_id',
            'supplier',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-price-unit_id',
            'price',
            'unit_id',
            'unit',
            'id',
            'CASCADE'
        );

        $this->createIndex('price-supplier_id-article-uniq-idx', 'price', ['supplier_id', 'article',], true);

        $this->createIndex('price-columns-idx', 'price', ['article', 'name', 'price1', 'count',]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210330_080807_lr_price cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210330_080807_lr_price cannot be reverted.\n";

        return false;
    }
    */
}
