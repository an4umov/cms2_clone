<?php

use yii\db\Migration;

/**
 * Class m200206_111444_form_alter
 */
class m200206_111444_form_alter extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Form::tableName(), 'color', $this->string(15));
        $this->addColumn(\common\models\Form::tableName(), 'emails', $this->text()->comment('JSON'));
        $this->addColumn(\common\models\Form::tableName(), 'result', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Form::tableName(), 'color');
        $this->dropColumn(\common\models\Form::tableName(), 'emails');
        $this->dropColumn(\common\models\Form::tableName(), 'result');
    }
}
