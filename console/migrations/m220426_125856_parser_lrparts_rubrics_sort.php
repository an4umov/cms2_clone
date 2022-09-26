<?php

use yii\db\Migration;

/**
 * Class m220426_125856_parser_lrparts_rubrics_sort
 */
class m220426_125856_parser_lrparts_rubrics_sort extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\common\models\ParserLrpartsRubrics::tableName(), 'sort_field', $this->integer(11)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220426_125856_parser_lrparts_rubrics_sort cannot be reverted.\n";

        return false;
    }
}
