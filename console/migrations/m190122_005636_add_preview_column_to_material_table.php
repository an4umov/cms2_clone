<?php

use yii\db\Migration;

/**
 * Handles adding preview to table `material`.
 */
class m190122_005636_add_preview_column_to_material_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('material', 'preview', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('material', 'preview');
    }
}
