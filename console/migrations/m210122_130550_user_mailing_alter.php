<?php

use yii\db\Migration;

/**
 * Class m210122_130550_user_mailing_alter
 */
class m210122_130550_user_mailing_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_mailing', 'lk_mailing_id', $this->integer(11)->notNull()->after('user_id'));

        $this->addForeignKey(
            'fk-user_mailing-lk_mailing_id',
            'user_mailing',
            'lk_mailing_id',
            'lk_mailing',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_mailing-lk_mailing_id', 'user_mailing');
        $this->dropColumn('user_mailing', 'lk_mailing_id');
    }
}
