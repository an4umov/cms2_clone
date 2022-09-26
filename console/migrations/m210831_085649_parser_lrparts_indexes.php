<?php

use common\models\ParserLrpartsRubrics;
use yii\db\Migration;

/**
 * Class m210831_085649_parser_lrparts_indexes
 */
class m210831_085649_parser_lrparts_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('parser_lrparts_rubrics-idx', \common\models\ParserLrpartsRubrics::tableName(), ['url', 'parent_url',], true);
        $this->createIndex('parser_lrparts_items-idx', \common\models\ParserLrpartsItems::tableName(), ['url', 'rubric_id',], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('parser_lrparts_rubrics-idx', \common\models\ParserLrpartsRubrics::tableName());
        $this->dropIndex('parser_lrparts_items-idx', \common\models\ParserLrpartsItems::tableName());
    }
}
