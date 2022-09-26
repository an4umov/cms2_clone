<?php

use yii\db\Migration;

/**
 * Class m200511_142134_article_stock
 */
class m200511_142134_article_stock extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Articles::tableName(), 'is_in_stock', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Articles::tableName(), 'is_in_stock');
    }
}
