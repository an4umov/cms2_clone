<?php

use yii\db\Migration;

/**
 * Class m201217_074043_user_notice
 */
class m201217_074043_user_notice extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_notice', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),

            'is_order_received_email' => $this->boolean()->comment('Получение Вашего заказа из Интернет-магазина, email'),
            'order_received_email' => $this->string(100),
            'is_order_received_sms' => $this->boolean()->comment('Получение Вашего заказа из Интернет-магазина, sms'),
            'order_received_sms' => $this->string(25),

            'is_order_status_email' => $this->boolean()->comment('Изменение статуса Вашего заказа, email'),
            'order_status_email' => $this->string(100),
            'is_order_status_sms' => $this->boolean()->comment('Изменение статуса Вашего заказа, sms'),
            'order_status_sms' => $this->string(25),

            'is_balance_email' => $this->boolean()->comment('Изменение баланса взаиморасчетов (поступления и списания денег), email'),
            'balance_email' => $this->string(100),
            'is_balance_sms' => $this->boolean()->comment('Изменение баланса взаиморасчетов (поступления и списания денег), sms'),
            'balance_sms' => $this->string(25),

            'is_news_email' => $this->boolean()->comment('Новости компании и сайта, email'),
            'news_email' => $this->string(100),
            'is_defender_email' => $this->boolean()->comment('Рассылка для любителей Land Rover Defender, email'),
            'defender_email' => $this->string(100),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-user_notice-user_id',
            'user_notice',
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
        $this->dropForeignKey(
            'fk-user_notice-user_id',
            'user_delivery'
        );
        $this->dropTable('user_notice');
    }
}
