<?php

use yii\db\Migration;

/**
 * Handles adding alias to table `templates`.
 */
class m190211_222719_add_alias_column_to_templates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('templates', 'alias', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('templates', 'alias');
    }
}
