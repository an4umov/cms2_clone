<?php

use yii\db\Migration;

/**
 * Class m201030_083949_form_css_prefix
 */
class m201030_083949_form_css_prefix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Form::tableName(), 'css_prefix', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Form::tableName(), 'css_prefix');
    }
}
