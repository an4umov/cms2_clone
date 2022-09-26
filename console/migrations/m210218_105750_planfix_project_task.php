<?php

use yii\db\Migration;

/**
 * Class m210218_105750_planfix_project_task
 */
class m210218_105750_planfix_project_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE planfixProjectTaskType AS ENUM ('project', 'task')");

        $this->createTable('planfix_project_task', [
            'id' => $this->primaryKey(),
            'planfix_id' => $this->integer(11)->notNull(),
            'type' => "planfixProjectTaskType",
            'parent_id' => $this->integer(11),
            'email' => $this->string(255),
            'title' => $this->string(255),
            'description' => $this->text(),
            'status' => $this->string(50),
            'is_active' => $this->boolean(),
            'favoriteData' => $this->string()->comment('JSON'),
            'link' => $this->string(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('planfix_project_task-planfix_id-unq', 'planfix_project_task', ['planfix_id', 'type',], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE planfixProjectTaskType CASCADE');
        $this->dropIndex('planfix_project_task-planfix_id-unq', 'planfix_contact');
        $this->dropTable('planfix_project_task');
    }
}
