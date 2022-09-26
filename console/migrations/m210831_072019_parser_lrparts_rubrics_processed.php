<?php

use yii\db\Migration;

/**
 * Class m210831_072019_parser_lrparts_rubrics_processed
 */
class m210831_072019_parser_lrparts_rubrics_processed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_lrparts_rubrics_processed', [
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
        $this->execute('DROP TABLE parser_lrparts_rubrics_processed');
    }
}
