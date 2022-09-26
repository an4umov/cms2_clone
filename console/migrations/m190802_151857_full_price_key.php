<?php

use yii\db\Migration;

/**
 * Class m190802_151857_full_price_key
 */
class m190802_151857_full_price_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\FullPrice::tableName(), 'key', $this->string(\common\models\FullPrice::KEY_LENGTH));
        $this->createIndex('full_price-key-uniq', \common\models\FullPrice::tableName(), 'key', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('full_price-key-uniq', \common\models\FullPrice::tableName());
        $this->dropColumn(\common\models\FullPrice::tableName(), 'key');
    }
}
