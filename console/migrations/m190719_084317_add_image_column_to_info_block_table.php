<?php

use yii\db\Migration;

/**
 * Handles adding image to table `info_block`.
 * Has foreign keys to the tables:
 *
 * - `file`
 */
class m190719_084317_add_image_column_to_info_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('info_block', 'image', $this->integer());

        // creates index for column `image`
        $this->createIndex(
            'idx-info_block-image',
            'info_block',
            'image'
        );

        // add foreign key for table `file`
        $this->addForeignKey(
            'fk-info_block-image',
            'info_block',
            'image',
            'file',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `file`
        $this->dropForeignKey(
            'fk-info_block-image',
            'info_block'
        );

        // drops index for column `image`
        $this->dropIndex(
            'idx-info_block-image',
            'info_block'
        );

        $this->dropColumn('info_block', 'image');
    }
}
