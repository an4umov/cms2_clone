<?php

use yii\db\Migration;

/**
 * Class m220504_080115_landrover_classic
 */
class m220504_080115_landrover_classic extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_jaguarlandroverclassic_rubrics_processed', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('parser_jaguarlandroverclassic_rubrics', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11),
            'name' => $this->string()->notNull(),
            'sort' => $this->integer()->null(),
            'url' => $this->text()->notNull(),
            'description' => $this->text()->null(),
            'image' => $this->string()->null(),
            'is_active' => $this->boolean()->defaultValue(true),
            'is_last' => $this->boolean()->defaultValue(false),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('parser_jaguarlandroverclassic_items', [
            'id' => $this->primaryKey(),
            'rubric_id' => $this->integer(11)->notNull(),
            'parent_id' => $this->integer(11)->null(),
            'level' => $this->integer(11)->notNull(),
            'is_product' => $this->boolean()->defaultValue(false),
            'position' => $this->string()->null()->comment('Код слева 2B912A, <55100'),
            'name' => $this->string()->notNull(),
            'sort' => $this->integer()->null(),
            'url' => $this->text()->notNull(),
            'description' => $this->text()->null(),
            'is_active' => $this->boolean()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE parser_jaguarlandroverclassic_rubrics_processed');
        $this->execute('DROP TABLE parser_jaguarlandroverclassic_rubrics');
        $this->execute('DROP TABLE parser_jaguarlandroverclassic_items');
    }

}
