<?php

use yii\db\Migration;

/**
 * Handles adding description to table `composite`.
 */
class m190430_124245_add_description_column_to_composite_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('composite', 'description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('composite', 'description');
    }
}
