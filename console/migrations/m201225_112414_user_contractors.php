<?php

use yii\db\Migration;

/**
 * Class m201225_112414_user_contractors
 */
class m201225_112414_user_contractors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_contractor_entity', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),

            'is_default' => $this->boolean()->comment('Выбирать по умолчанию'),
            'is_active' => $this->boolean()->comment('Активен'),
            'inn' => $this->string(12)->notNull(),
            'name' => $this->string()->notNull(),
            'kpp' => $this->string(9)->notNull(),
            'ogrn' => $this->string(13)->notNull(),
            'address' => $this->text()->notNull(),
            'person' => $this->string()->null()->comment('Уполномоченное лицо'),
            'reason' => $this->string()->null()->comment('Действует на основании'),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-user_contractor_entity-user_id',
            'user_contractor_entity',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->createTable('user_contractor_person', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),

            'is_default' => $this->boolean()->comment('Выбирать по умолчанию'),
            'is_active' => $this->boolean()->comment('Активен'),
            'firstname' => $this->string(50),
            'lastname' => $this->string(50),
            'secondname' => $this->string(50),
            'address' => $this->string(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-user_contractor_person-user_id',
            'user_contractor_person',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user_contractor_entity-user_id',
            'user_contractor_entity'
        );
        $this->dropForeignKey(
            'fk-user_contractor_person-user_id',
            'user_contractor_person'
        );
        $this->dropTable('user_contractor_entity');
        $this->dropTable('user_contractor_person');
    }
}
