<?php

use yii\db\Migration;

/**
 * Handles the creation of table `material`.
 */
class m181216_162923_create_material_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('material', [
            'id' => $this->primaryKey(),
            'title' => $this->string(256)->notNull(),
            'alias' => $this->string(256)->unique()->notNull(),
            'content' => $this->text(),
            'type_id' => $this->tinyInteger(2),
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
        $this->dropTable('material');
    }
}
