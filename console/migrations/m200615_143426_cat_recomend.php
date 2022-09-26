<?php

use yii\db\Migration;

/**
 * Class m200615_143426_cat_recomend
 */
class m200615_143426_cat_recomend extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cat_recomend', [
            'id' => $this->primaryKey(),
            'cat' => $this->string(16)->notNull(),
            'recomend_cat' => $this->string(16)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('cat_recomend');
    }
}
