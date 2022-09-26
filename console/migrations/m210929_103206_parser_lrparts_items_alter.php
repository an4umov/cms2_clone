<?php

use yii\db\Migration;

/**
 * Class m210929_103206_parser_lrparts_items_alter
 */
class m210929_103206_parser_lrparts_items_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\ParserLrpartsRubrics::tableName(), 'catalog_codes', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\ParserLrpartsRubrics::tableName(), 'catalog_codes');
    }
}
