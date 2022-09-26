<?php

use yii\db\Migration;

/**
 * Class m191231_141508_reference
 */
class m191231_141508_reference extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reference', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('reference_value', [
            'id' => $this->primaryKey(),
            'reference_id' => $this->integer()->notNull(),
            'name' => $this->string(128)->notNull(),
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reference_value-reference_id',
            'reference_value',
            'reference_id',
            'reference',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE reference_value CASCADE');
        $this->execute('DROP TABLE reference CASCADE');
    }
}
