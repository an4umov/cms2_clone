<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag_material`.
 * Has foreign keys to the tables:
 *
 * - `tag`
 * - `material`
 */
class m181216_164810_create_junction_table_for_tag_and_material_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag_material', [
            'tag_id' => $this->integer(),
            'material_id' => $this->integer(),
            'PRIMARY KEY(tag_id, material_id)',
        ]);

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-tag_material-tag_id',
            'tag_material',
            'tag_id'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-tag_material-tag_id',
            'tag_material',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );

        // creates index for column `material_id`
        $this->createIndex(
            'idx-tag_material-material_id',
            'tag_material',
            'material_id'
        );

        // add foreign key for table `material`
        $this->addForeignKey(
            'fk-tag_material-material_id',
            'tag_material',
            'material_id',
            'material',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `tag`
        $this->dropForeignKey(
            'fk-tag_material-tag_id',
            'tag_material'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-tag_material-tag_id',
            'tag_material'
        );

        // drops foreign key for table `material`
        $this->dropForeignKey(
            'fk-tag_material-material_id',
            'tag_material'
        );

        // drops index for column `material_id`
        $this->dropIndex(
            'idx-tag_material-material_id',
            'tag_material'
        );

        $this->dropTable('tag_material');
    }
}
