<?php

use yii\db\Migration;

/**
 * Class m210811_114446_parser_proverkacheka
 */
class m210811_114446_parser_proverkacheka extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parser_proverkacheka', [
            'id' => $this->primaryKey(),
            'number' => $this->integer(11)->notNull(),
            'inn' => $this->string(50)->notNull(),
            'total' => $this->float(2)->notNull(),
            'type' => $this->string(50)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TABLE parser_proverkacheka');
    }
}
