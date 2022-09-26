<?php

use yii\db\Migration;

/**
 * Class m191024_105741_settings
 */
class m191024_105741_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE settingsType AS ENUM ('news','article','page')");
        $this->createTable('settings', [
            'id' => $this->primaryKey(),
            'type' => "settingsType",
            'data' => $this->text()->comment('JSON'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('settings');
    }
}
