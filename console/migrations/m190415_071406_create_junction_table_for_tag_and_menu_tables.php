<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag_menu`.
 * Has foreign keys to the tables:
 *
 * - `tag`
 * - `menu`
 */
class m190415_071406_create_junction_table_for_tag_and_menu_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag_menu', [
            'tag_id' => $this->integer(),
            'menu_id' => $this->integer(),
            'PRIMARY KEY(tag_id, menu_id)',
        ]);

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-tag_menu-tag_id',
            'tag_menu',
            'tag_id'
        );

        // add foreign key for table `tag`
        $this->addForeignKey(
            'fk-tag_menu-tag_id',
            'tag_menu',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );

        // creates index for column `menu_id`
        $this->createIndex(
            'idx-tag_menu-menu_id',
            'tag_menu',
            'menu_id'
        );

        // add foreign key for table `menu`
        $this->addForeignKey(
            'fk-tag_menu-menu_id',
            'tag_menu',
            'menu_id',
            'menu',
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
            'fk-tag_menu-tag_id',
            'tag_menu'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-tag_menu-tag_id',
            'tag_menu'
        );

        // drops foreign key for table `menu`
        $this->dropForeignKey(
            'fk-tag_menu-menu_id',
            'tag_menu'
        );

        // drops index for column `menu_id`
        $this->dropIndex(
            'idx-tag_menu-menu_id',
            'tag_menu'
        );

        $this->dropTable('tag_menu');
    }
}
