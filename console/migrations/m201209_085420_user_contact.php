<?php

use yii\db\Migration;

/**
 * Class m201209_085420_user_contact
 */
class m201209_085420_user_contact extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE userContactSexType AS ENUM ('male','female')");

        $this->createTable('user_contact', [
            'id'                    => $this->primaryKey(),
            'user_id'               => $this->integer()->notNull(),
            'sex'                   => "userContactSexType",
            'firstname'             => $this->string(50),
            'lastname'              => $this->string(50),
            'secondname'            => $this->string(50),
            'phones'                => $this->text()->comment('JSON'),
            'email'                 => $this->string(100),
            'position'              => $this->string(100),
            'info'                  => $this->text(),
            'is_main'               => $this->boolean(),
            'is_main_contractor'    => $this->boolean(),
            'created_at'            => $this->integer(),
            'updated_at'            => $this->integer(),
            'deleted_at'            => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_contact');
        $this->execute('DROP TYPE userContactSexType CASCADE');
    }
}
