<?php

use yii\db\Migration;

/**
 * Class m220301_112406_parser_lrparts_rubrics_alter
 */
class m220301_112406_parser_lrparts_rubrics_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\ParserLrpartsRubrics::tableName(), 'is_active', $this->boolean()->defaultValue(true));
        $this->addColumn(\common\models\ParserLrpartsRubrics::tableName(), 'sort_field', $this->string(20));
        $this->addColumn(\common\models\ParserLrpartsRubrics::tableName(), 'title', $this->string());
        $this->addColumn(\common\models\ParserLrpartsRubrics::tableName(), 'page_header', $this->string()->defaultValue('')->notNull());
        $this->addColumn(\common\models\ParserLrpartsRubrics::tableName(), 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\ParserLrpartsRubrics::tableName(), 'is_active');
        $this->dropColumn(\common\models\ParserLrpartsRubrics::tableName(), 'sort_field');
        $this->dropColumn(\common\models\ParserLrpartsRubrics::tableName(), 'title');
        $this->dropColumn(\common\models\ParserLrpartsRubrics::tableName(), 'page_header');
        $this->dropColumn(\common\models\ParserLrpartsRubrics::tableName(), 'description');
    }
}
