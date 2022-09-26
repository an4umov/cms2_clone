<?php

use yii\db\Migration;

/**
 * Class m190905_143545_blocks
 */
class m190905_143545_blocks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE blockType AS ENUM ('gallery','text','banner','slider','filter')");
        $this->createTable('block', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'type' => "blockType",
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->createIndex('block-type-idx', 'block', 'type');

        $this->execute("CREATE TYPE blockFieldType AS ENUM ('textarea','textarea_ext','image','taxonomy','text','digit','date','article_id','page_id','bool','color','list')");
        $this->createTable('block_field', [
            'id' => $this->primaryKey(),
            'block_id' => $this->integer(11)->notNull(),
            'name' => $this->string(128)->notNull(),
            'type' => "blockFieldType",
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->createIndex('block_field-block_id-idx', 'block_field', 'block_id');
        $this->addForeignKey(
            'fk-block_field-block_id',
            'block_field',
            'block_id',
            'block',
            'id',
            'CASCADE'
        );

        $this->execute("CREATE TYPE fieldType AS ENUM ('textarea','textarea_ext','image','taxonomy','text','digit','date','article_id','page_id','bool','color')");
        $this->createTable('block_field_list', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(11)->notNull(),
            'name' => $this->string(128)->notNull(),
            'type' => "fieldType",
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->createIndex('block_field_list-field_id-idx', 'block_field_list', 'field_id');
        $this->addForeignKey(
            'fk-block_field_list-field_id',
            'block_field_list',
            'field_id',
            'block_field',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE blockType CASCADE');
        $this->execute('DROP TYPE blockFieldType CASCADE');
        $this->execute('DROP TYPE fieldType CASCADE');

        $this->execute('DROP TABLE block CASCADE');
        $this->execute('DROP TABLE block_field CASCADE');
        $this->execute('DROP TABLE block_field_list CASCADE');

        //        $this->dropTable('block');
//        $this->dropTable('block_field');
//        $this->dropTable('block_field_list');
    }
}
