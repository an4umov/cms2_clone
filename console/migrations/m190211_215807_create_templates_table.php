<?php

use yii\db\Migration;

/**
 * Handles the creation of table `templates`.
 */
class m190211_215807_create_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('templates', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'content' => $this->text(),
            'active' => $this->tinyInteger(),
            'type' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('templates');
    }
}
