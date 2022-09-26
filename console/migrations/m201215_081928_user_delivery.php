<?php

use yii\db\Migration;

/**
 * Class m201215_081928_user_delivery
 */
class m201215_081928_user_delivery extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_delivery', [
            'id'                    => $this->primaryKey(),
            'user_id'               => $this->integer()->notNull(),
            'title'                 => $this->string(150)->notNull(),
            'is_main'               => $this->boolean()->comment('Основной адрес доставки'),
            'is_post'               => $this->boolean()->comment('Использовать этот адрес для почтовой корреспонденции'),
            'country'               => $this->string(100)->notNull(),
            'region'                => $this->string(100)->notNull(),
            'city'                  => $this->string(100)->notNull(),
            'street'                => $this->string(100)->notNull(),
            'house'                 => $this->string(25)->notNull()->comment('Дом'),
            'building'              => $this->string(25)->comment('Корпус'),
            'entrance'              => $this->string(10)->comment('Подъезд'),
            'apartment'             => $this->string(10)->comment('Квартира'),
            'structure'             => $this->string(25)->comment('Строение'),
            'floor'                 => $this->string(10)->comment('Этаж'),
            'index'                 => $this->string(10)->comment('Индекс'),
            'info'                  => $this->text()->comment('Дополнительная информация'),
            'created_at'            => $this->integer(),
            'updated_at'            => $this->integer(),
            'deleted_at'            => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-user_delivery-user_id',
            'user_delivery',
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
            'fk-user_delivery-user_id',
            'user_delivery'
        );
        $this->dropTable('user_delivery');
    }
}
