<?php

use yii\db\Migration;

/**
 * Class m220218_084413_parser_britauto_process
 */
class m220218_084413_parser_britauto_process extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_britauto_processed', [
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
        $this->execute('DROP TABLE parser_britauto_processed');
    }
}
