<?php

use yii\db\Migration;

/**
 * Class m200210_151117_form_color_bg
 */
class m200210_151117_form_color_bg extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Form::tableName(), 'color_bg', $this->string(15));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Form::tableName(), 'color_bg');
    }
}
