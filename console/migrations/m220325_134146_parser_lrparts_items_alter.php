<?php

use yii\db\Migration;

/**
 * Class m220325_134146_parser_lrparts_items_alter
 */
class m220325_134146_parser_lrparts_items_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\ParserLrpartsItems::tableName(), 'is_active', $this->boolean()->defaultValue(true)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\ParserLrpartsItems::tableName(), 'is_active');
    }
}
