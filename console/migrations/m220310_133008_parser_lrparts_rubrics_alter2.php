<?php

use yii\db\Migration;

/**
 * Class m220310_133008_parser_lrparts_rubrics_alter2
 */
class m220310_133008_parser_lrparts_rubrics_alter2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\ParserLrpartsRubrics::tableName(), 'image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\ParserLrpartsRubrics::tableName(), 'image');
    }
}
