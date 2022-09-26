<?php

use yii\db\Migration;

/**
 * Class m220527_112727_parser_lrparts_rubrics_alter
 */
class m220527_112727_parser_lrparts_rubrics_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\ParserLrpartsRubrics::tableName(), 'description_bottom', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\ParserLrpartsRubrics::tableName(), 'description_bottom');
    }
}
