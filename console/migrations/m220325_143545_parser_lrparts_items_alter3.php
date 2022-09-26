<?php

use yii\db\Migration;

/**
 * Class m220325_143545_parser_lrparts_items_alter3
 */
class m220325_143545_parser_lrparts_items_alter3 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\common\models\ParserLrpartsItems::tableName(), 'url', $this->string()->null());
        $this->alterColumn(\common\models\ParserLrpartsItems::tableName(), 'path', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220325_143545_parser_lrparts_items_alter3 cannot be reverted.\n";

        return false;
    }
}
