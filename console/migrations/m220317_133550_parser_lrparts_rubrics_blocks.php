<?php

use yii\db\Migration;

/**
 * Class m220317_133550_parser_lrparts_rubrics_blocks
 */
class m220317_133550_parser_lrparts_rubrics_blocks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_lrparts_rubrics_block', [
            'id' => $this->primaryKey(),
            'rubric_id' => $this->integer(11)->notNull(),
            'block_id' => $this->integer(11)->notNull(),
            'sort' => $this->integer(11)->notNull(),
            'is_active' => $this->boolean()->defaultValue(true)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-parser_lrparts_rubrics_block-parser_lrparts_rubrics_id',
            'parser_lrparts_rubrics_block',
            'rubric_id',
            'parser_lrparts_rubrics',
            'id',
            'NO ACTION'
        );
        $this->addForeignKey(
            'fk-parser_lrparts_rubrics_block-block_id',
            'parser_lrparts_rubrics_block',
            'block_id',
            'block',
            'id',
            'NO ACTION'
        );


        $this->createTable('parser_lrparts_rubrics_block_field', [
            'id' => $this->primaryKey(),
            'parser_lrparts_rubrics_block_id' => $this->integer(11)->notNull(),
            'data' => $this->text()->notNull()->comment('JSON'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-parser_lrparts_rubrics_block_field-block_id',
            'parser_lrparts_rubrics_block_field',
            'parser_lrparts_rubrics_block_id',
            'block',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE parser_lrparts_rubrics_block CASCADE');
        $this->execute('DROP TABLE parser_lrparts_rubrics_block_field CASCADE');
    }
}
