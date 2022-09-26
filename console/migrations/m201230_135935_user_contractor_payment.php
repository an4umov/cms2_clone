<?php

use yii\db\Migration;

/**
 * Class m201230_135935_user_contractor_payment
 */
class m201230_135935_user_contractor_payment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE userContractorPaymentType AS ENUM ('transfer', 'cash', 'card')");
        $this->createTable('user_contractor_payment', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'entity_id' => $this->integer(),
            'person_id' => $this->integer(),
            'type' => "userContractorPaymentType",
            'is_default' => $this->boolean()->comment('Основная форма'),

            'bik' => $this->string(20),
            'correspondent_account' => $this->string(20),
            'bank' => $this->string(),
            'payment_account' => $this->string(50)->comment('Расчётный счёт'),

            'number' => $this->string(50),
            'month' => $this->integer(11),
            'year' => $this->integer(11),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'deleted_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-user_contractor_payment-user_id',
            'user_contractor_payment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE userContractorPaymentType CASCADE');

        $this->dropForeignKey(
            'fk-user_contractor_payment-user_id',
            'user_contractor_payment'
        );

        $this->execute('DROP TABLE user_contractor_payment CASCADE');
    }
}
