<?php

use yii\db\Migration;

/**
 * Class m210210_101221_planfix_partner_alter
 */
class m210210_101221_planfix_partner_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('planfix_partner-planfix_id-unq', 'planfix_partner', 'planfix_id', true);

        $this->addForeignKey(
            'fk-planfix_partner_ext-planfix_id',
            'planfix_partner_ext',
            'planfix_id',
            'planfix_partner',
            'planfix_id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('planfix_partner-planfix_id-unq', 'planfix_partner');
        $this->dropForeignKey('fk-planfix_partner_ext-planfix_id', 'planfix_partner_ext');
    }
}
