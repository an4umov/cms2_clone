<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu_material`.
 * Has foreign keys to the tables:
 *
 * - `menu`
 * - `material`
 */
class m181216_164638_create_junction_table_for_menu_and_material_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('menu_material', [
            'menu_id' => $this->integer(),
            'material_id' => $this->integer(),
            'is_default' => $this->tinyInteger(1),
            'PRIMARY KEY(menu_id, material_id)',
        ]);

        // creates index for column `menu_id`
        $this->createIndex(
            'idx-menu_material-menu_id',
            'menu_material',
            'menu_id'
        );

        // add foreign key for table `menu`
        $this->addForeignKey(
            'fk-menu_material-menu_id',
            'menu_material',
            'menu_id',
            'menu',
            'id',
            'CASCADE'
        );

        // creates index for column `material_id`
        $this->createIndex(
            'idx-menu_material-material_id',
            'menu_material',
            'material_id'
        );

        // add foreign key for table `material`
        $this->addForeignKey(
            'fk-menu_material-material_id',
            'menu_material',
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
        // drops foreign key for table `menu`
        $this->dropForeignKey(
            'fk-menu_material-menu_id',
            'menu_material'
        );

        // drops index for column `menu_id`
        $this->dropIndex(
            'idx-menu_material-menu_id',
            'menu_material'
        );

        // drops foreign key for table `material`
        $this->dropForeignKey(
            'fk-menu_material-material_id',
            'menu_material'
        );

        // drops index for column `material_id`
        $this->dropIndex(
            'idx-menu_material-material_id',
            'menu_material'
        );

        $this->dropTable('menu_material');
    }
}
