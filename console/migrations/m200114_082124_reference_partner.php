<?php

use yii\db\Migration;

/**
 * Class m200114_082124_reference_partner
 */
class m200114_082124_reference_partner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reference_partner', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'description' => $this->text(),
            'icon' => $this->string(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('reference_partner');
    }
}
