<?php

use yii\db\Migration;

/**
 * Class m220222_083317_parser_landspirit
 */
class m220222_083317_parser_landspirit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_landspirit_processed', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE parser_landspirit_processed');
    }
}
