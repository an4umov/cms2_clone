<?php

use yii\db\Migration;

/**
 * Class m200630_103333_order_status
 */
class m200630_103333_order_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE orderStatusType AS ENUM ('pending', 'waiting_for_capture', 'succeeded', 'canceled')");
        $this->addColumn(\common\models\Order::tableName(), 'status', "orderStatusType");

        $this->createTable('order_log', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'status' => "orderStatusType",
            'message' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-order_log-order_id',
            'order_log',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE contentType CASCADE');

        $this->dropColumn(\common\models\Order::tableName(), 'status');

        $this->dropForeignKey(
            'fk-order_log-order_id',
            'order_log'
        );

        $this->dropTable('order_log');
    }
}
