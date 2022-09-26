<?php

use yii\db\Migration;

/**
 * Class m210125_080947_green_menu
 */
class m210125_080947_green_menu extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('green_menu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'landing_page_id' => $this->integer(11)->notNull(),
            'sort' => $this->integer(11)->notNull(),
            'is_enabled' => $this->boolean(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('green_menu');
    }
}
