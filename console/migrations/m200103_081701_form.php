<?php

use yii\db\Migration;

/**
 * Class m200103_081701_form
 */
class m200103_081701_form extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('form', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->execute("CREATE TYPE formFieldType AS ENUM ('textarea','text','email','phone','checkbox','reference_id')");
        $this->createTable('form_field', [
            'id' => $this->primaryKey(),
            'form_id' => $this->integer(11)->notNull(),
            'name' => $this->string(128)->notNull(),
            'data' => $this->text()->notNull()->comment('JSON'),
            'type' => "formFieldType",
            'sort' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-form_field-form_id',
            'form_field',
            'form_id',
            'form',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE formFieldType CASCADE');

        $this->execute('DROP TABLE form CASCADE');
        $this->execute('DROP TABLE form_field CASCADE');
    }
}
