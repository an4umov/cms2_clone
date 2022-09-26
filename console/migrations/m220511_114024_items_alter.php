<?php

use yii\db\Migration;

/**
 * Class m220511_114024_items_alter
 */
class m220511_114024_items_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Articles::tableName(), 'is_in_epc', $this->boolean()->defaultValue(false)->comment('Есть ли соответствие code в таблице parser_lrparts_items.code'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Articles::tableName(), 'is_in_epc');
    }
}
