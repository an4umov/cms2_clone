<?php

use yii\db\Migration;

/**
 * Class m210215_162556_contact_alter
 */
class m210215_162556_contact_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(\common\models\PlanfixContact::tableName(), 'customData', $this->text());
        $this->alterColumn(\common\models\PlanfixContact::tableName(), 'phones', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(\common\models\PlanfixContact::tableName(), 'customData', $this->string());
        $this->alterColumn(\common\models\PlanfixContact::tableName(), 'phones', $this->string());
    }
}
