<?php

use yii\db\Migration;

/**
 * Class m200629_132715_order_item_key
 */
class m200629_132715_order_item_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\OrderItem::tableName(), 'key', $this->string(\common\models\PriceList::KEY_LENGTH)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\OrderItem::tableName(), 'key');
    }
}
