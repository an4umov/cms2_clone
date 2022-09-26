<?php

use yii\db\Migration;

/**
 * Class m220325_143419_parser_lrparts_items_alter2
 */
class m220325_143419_parser_lrparts_items_alter2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('parser_lrparts_rubrics-idx', \common\models\ParserLrpartsRubrics::tableName());
        $this->dropIndex('parser_lrparts_items-idx', \common\models\ParserLrpartsItems::tableName());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220325_143419_parser_lrparts_items_alter2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220325_143419_parser_lrparts_items_alter2 cannot be reverted.\n";

        return false;
    }
    */
}
