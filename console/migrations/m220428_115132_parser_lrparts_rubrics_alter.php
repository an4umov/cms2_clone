<?php

use yii\db\Migration;

/**
 * Class m220428_115132_parser_lrparts_rubrics_alter
 */
class m220428_115132_parser_lrparts_rubrics_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\common\models\ParserLrpartsRubrics::tableName(), 'url', $this->string()->null());
        $this->alterColumn(\common\models\ParserLrpartsRubrics::tableName(), 'path', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220428_115132_parser_lrparts_rubrics_alter cannot be reverted.\n";

        return false;
    }
}
