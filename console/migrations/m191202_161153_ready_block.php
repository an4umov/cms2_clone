<?php

use yii\db\Migration;

/**
 * Class m191202_161153_ready_block
 */
class m191202_161153_ready_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('block_ready', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'type' => "blockType",
            'global_type' => "blockGlobalType",
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'data' => $this->text()->notNull()->comment('JSON'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        /////////////////////////////////////

        $this->createTable('block_ready_field', [
            'id' => $this->primaryKey(),
            'block_id' => $this->integer(11)->notNull(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->string()->null(),
            'type' => "blockFieldType",
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createIndex('block_ready_field-block_id-idx', 'block_ready_field', 'block_id');
        $this->addForeignKey(
            'fk-block_ready_field-block_id',
            'block_ready_field',
            'block_id',
            'block_ready',
            'id',
            'CASCADE'
        );

        /////////////////////////////////////

        $this->createTable('block_ready_field_list', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(11)->notNull(),
            'name' => $this->string(128)->notNull(),
            'type' => "fieldType",
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createIndex('block_ready_field_list-field_id-idx', 'block_ready_field_list', 'field_id');
        $this->addForeignKey(
            'fk-block_ready_field_list-field_id',
            'block_ready_field_list',
            'field_id',
            'block_ready_field',
            'id',
            'CASCADE'
        );

        /////////////////////////////////////

        $this->createTable('block_ready_field_values_list', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(11)->notNull(),
            'value' => $this->string(128)->notNull(),
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createIndex('block_ready_field_values_list-field_id-idx', 'block_ready_field_values_list', 'field_id');
        $this->addForeignKey(
            'fk-block_ready_field_values_list-field_id',
            'block_ready_field_values_list',
            'field_id',
            'block_ready_field',
            'id',
            'CASCADE'
        );

        /////////////////////////////////////

        $this->execute("CREATE TYPE contentBlockType AS ENUM ('block','block_ready')");
        $this->addColumn(\common\models\ContentBlock::tableName(), 'type', "contentBlockType");
        \common\models\ContentBlock::updateAll(['type' => 'block',]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE block_ready_field_values_list CASCADE');
        $this->execute('DROP TABLE block_ready_field_list CASCADE');
        $this->execute('DROP TABLE block_ready_field CASCADE');
        $this->execute('DROP TABLE block_ready CASCADE');

        $this->dropColumn(\common\models\ContentBlock::tableName(), 'type');
        $this->execute('DROP TYPE contentBlockType CASCADE');
    }
}
