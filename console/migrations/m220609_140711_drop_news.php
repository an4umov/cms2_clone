<?php

use yii\db\Migration;

/**
 * Class m220609_140711_drop_news
 */
class m220609_140711_drop_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('news');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220609_140711_drop_news cannot be reverted.\n";

        return false;
    }
}
