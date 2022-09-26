<?php

use yii\db\Migration;

/**
 * Class m210818_071025_lrparts_ru
 */
class m210818_071025_lrparts_ru extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_lrparts_rubrics', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(11),
            'name' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'path' => $this->text()->notNull(),
            'parent_url' => $this->string()->null(),
            'is_last' => $this->boolean()->defaultValue(false),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('parser_lrparts_items', [
            'id' => $this->primaryKey(),
            'rubric_id' => $this->integer(11)->notNull(),
            'position' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'code' => $this->string(25)->notNull(),
            'url' => $this->string()->notNull(),
            'path' => $this->text()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE parser_lrparts_rubrics');
        $this->execute('DROP TABLE parser_lrparts_items');
    }
}
