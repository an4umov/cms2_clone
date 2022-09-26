<?php

use yii\db\Migration;

/**
 * Class m220621_113508_shop_order
 */
class m220621_113508_shop_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE shopOrderUserType AS ENUM ('private_person','legal_person')");
        $this->execute("CREATE TYPE shopOrderLegalType AS ENUM ('ip','company')");
        $this->execute("CREATE TYPE shopOrderLegalPaymentType AS ENUM ('bank_transfer')");

        $this->createTable('shop_order', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'coupon_id' => $this->integer()->null()->comment('Купон'),
            'coupon_cost' => $this->float(2)->null()->comment('Скидка по купону'),
            'event_id' => $this->integer()->null()->comment('Акция'),
            'event_cost' => $this->float(2)->null()->comment('Скидка по акции'),
            'discount' => $this->integer()->null()->comment('Текущая скидка на момент покупки'),
            'discount_cost' => $this->float(2)->null()->comment('Значение по текущей скидке'),
            'total' => $this->float(2)->notNull()->comment('Итого без учета скидок'),
            'total_cost' => $this->float(2)->notNull()->comment('Итого с учетом скидок'),

            'is_need_installation' => $this->boolean()->defaultValue(false)->comment('Требуется услуга по установке приобретенных деталей?'),

            'cargo_weight' => $this->float(2)->null()->comment('Вес груза, кг'),
            'cargo_length' => $this->float(2)->null()->comment('Длина груза, м'),
            'cargo_height' => $this->float(2)->null()->comment('Высота груза, м'),
            'cargo_width' => $this->float(2)->null()->comment('Ширина груза, м'),
            'cargo_volume' => $this->float(2)->null()->comment('Объём груза, м3'),

            'email' => $this->string(150)->notNull(),
            'phone' => $this->string(150)->notNull(),
            'name' => $this->string()->notNull(),
            'user_type' => "shopOrderUserType",

            'legal_type' => "shopOrderLegalType",
            'legal_inn' => $this->string(30)->comment('ИНН'),
            'legal_kpp' => $this->string(30)->comment('КПП'),
            'legal_organization_name' => $this->string()->comment('Наименование организации'),
            'legal_address' => $this->text()->comment('Юр. адрес'),
            'legal_payment' => "shopOrderLegalPaymentType",
            'legal_bik' => $this->string()->comment('БИК'),
            'legal_bank' => $this->string()->comment('Банк'),
            'legal_correspondent_account' => $this->string()->comment('Корреспондентский счет'),
            'legal_payment_account' => $this->string()->comment('Расчетный счет'),
            'legal_comment' => $this->text()->comment('Комментарий'),

            'settings_delivery_id' => $this->integer()->null()->comment('Настройка корзины, доставка'),
            'delivery_comment' => $this->text()->comment('Комментарий по доставке'),

            'settings_payment_id' => $this->integer()->null()->comment('Настройка корзины, оплата'),
            'payment_comment' => $this->text()->comment('Комментарий по оплате'),

            'comment' => $this->text()->comment('Комментарий к заказу'),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('shop_order_item', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'article_id' => $this->integer()->notNull(),
            'code' => $this->string(64)->notNull(),
            'article_number' => $this->string(64)->notNull(),
            'product_code' => $this->string(64),
            'manufacturer' => $this->string(64)->notNull(),
            'price' => $this->float(2)->notNull(),
            'key' => $this->string(\common\models\PriceList::KEY_LENGTH)->notNull(),

            'quantity' => $this->integer()->notNull(),

            'name' => $this->string(255)->notNull(),
            'title' => $this->string(255),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_shop_order_item_order_id',
            'shop_order_item',
            'order_id',
            'shop_order',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE shopOrderUserType CASCADE');
        $this->execute('DROP TYPE shopOrderLegalType CASCADE');
        $this->execute('DROP TYPE shopOrderLegalPaymentType CASCADE');

        $this->dropTable('shop_order_item');
        $this->dropTable('shop_order');
    }
}
