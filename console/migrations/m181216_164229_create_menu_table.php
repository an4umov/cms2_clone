<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m181216_164229_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(256)->notNull(),
            'alias' => $this->string(256)->unique()->notNull(),
            'parent_id' => $this->integer(),
            'status' => $this->tinyInteger(1),
            'created_at' => $this->integer(10),
            'updated_at' => $this->integer(10),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('menu');
    }
}
