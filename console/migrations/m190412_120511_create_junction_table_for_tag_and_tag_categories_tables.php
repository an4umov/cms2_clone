<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag_tag_categories`.
 * Has foreign keys to the tables:
 *
 * - `tag`
 * - `tag_categories`
 */
class m190412_120511_create_junction_table_for_tag_and_tag_categories_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag_tag_categories', [
            'tag_id' => $this->integer(),
            'tag_categories_id' => $this->integer(),
            'PRIMARY KEY(tag_id, tag_categories_id)',
        ]);

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-tag_tag_categories-tag_id',
            'tag_tag_categories',
            'tag_id'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-tag_tag_categories-tag_id',
            'tag_tag_categories',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_categories_id`
        $this->createIndex(
            'idx-tag_tag_categories-tag_categories_id',
            'tag_tag_categories',
            'tag_categories_id'
        );

        // add foreign key for table `tag_categories`
        $this->addForeignKey(
            'fk-tag_tag_categories-tag_categories_id',
            'tag_tag_categories',
            'tag_categories_id',
            'tag_categories',
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
            'fk-tag_tag_categories-tag_id',
            'tag_tag_categories'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-tag_tag_categories-tag_id',
            'tag_tag_categories'
        );

        // drops foreign key for table `tag_categories`
        $this->dropForeignKey(
            'fk-tag_tag_categories-tag_categories_id',
            'tag_tag_categories'
        );

        // drops index for column `tag_categories_id`
        $this->dropIndex(
            'idx-tag_tag_categories-tag_categories_id',
            'tag_tag_categories'
        );

        $this->dropTable('tag_tag_categories');
    }
}
