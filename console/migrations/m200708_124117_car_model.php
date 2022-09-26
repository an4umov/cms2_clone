<?php

use yii\db\Migration;

/**
 * Class m200708_124117_car_model
 */
class m200708_124117_car_model extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('car_model', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('car_model');
    }
}
