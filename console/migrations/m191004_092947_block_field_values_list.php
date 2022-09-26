<?php

use yii\db\Migration;

/**
 * Class m191004_092947_block_field_values_list
 */
class m191004_092947_block_field_values_list extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('block_field_values_list', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(11)->notNull(),
            'value' => $this->string(128)->notNull(),
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->createIndex('block_field_values_list-field_id-idx', 'block_field_values_list', 'field_id');
        $this->addForeignKey(
            'fk-block_field_values_list-field_id',
            'block_field_values_list',
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
        $this->execute('DROP TABLE block_field_values_list CASCADE');
    }
}
