<?php

use yii\db\Migration;

/**
 * Class m210209_085716_planfix_partner
 */
class m210209_085716_planfix_partner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE planfixPartnerType AS ENUM ('contact', 'company')");

        $this->createTable('planfix_partner', [
            'id' => $this->primaryKey(),
            'planfix_id' => $this->integer(11)->notNull(),
            'one_c_id' => $this->integer(11)->comment('1C'),
            'name' => $this->string(255)->notNull(),
            'type' => "planfixPartnerType",
            'info' => $this->text(),
            'terms' => $this->text(),
            'last_change_info' => $this->text()->comment('JSON'),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);


        $this->execute("CREATE TYPE planfixPartnerExtType AS ENUM ('phone', 'email', 'address', 'site', 'skype', 'facebook', 'telegram', 'instagram')");

        $this->createTable('planfix_partner_ext', [
            'id' => $this->primaryKey(),
            'planfix_id' => $this->integer(11)->notNull(),
            'type' => "planfixPartnerExtType",
            'kind' => $this->string(255)->comment('Вид контактной информации'),
            'value' => $this->string(),
            'last_change_info' => $this->text()->comment('JSON'),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE planfixPartnerExtType CASCADE');
        $this->execute('DROP TYPE planfixPartnerType CASCADE');

        $this->execute('DROP TABLE planfix_partner_ext CASCADE');
        $this->execute('DROP TABLE planfix_partner CASCADE');
    }
}
