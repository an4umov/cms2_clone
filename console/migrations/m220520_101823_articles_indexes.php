<?php

use yii\db\Migration;

/**
 * Class m220520_101823_articles_indexes
 */
class m220520_101823_articles_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('parser_lrparts_items-code-idx', \common\models\ParserLrpartsItems::tableName(), 'code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('parser_lrparts_items-code-idx', \common\models\ParserLrpartsItems::tableName());
    }
}
