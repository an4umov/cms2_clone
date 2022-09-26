<?php

use yii\db\Migration;

/**
 * Class m191129_070541_full_price_idx2
 */
class m191129_070541_full_price_idx2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('full_price-article_number-delivery-idx', \common\models\FullPrice::tableName(), ['article_number', 'delivery',]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('full_price-article_number-delivery-idx', \common\models\FullPrice::tableName());
    }
}
