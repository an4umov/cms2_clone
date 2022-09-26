<?php

use yii\db\Migration;

/**
 * Class m200714_073233_content_filter_car_model
 */
class m200714_073233_content_filter_car_model extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('content_filter_car_model', [
            'id' => $this->primaryKey(),
            'content_id' => $this->integer(11)->notNull(),
            'car_model_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk-content_filter_car_model-content_id',
            'content_filter_car_model',
            'content_id',
            'content',
            'id',
            'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-content_filter_car_model-content_id', 'content_filter_car_model');
        $this->execute('DROP TABLE content_filter_car_model CASCADE');
    }
}
