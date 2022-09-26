<?php

use yii\db\Migration;

/**
 * Class m200928_110605_content_page_title
 */
class m200928_110605_content_page_title extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Content::tableName(), 'title', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Content::tableName(), 'title');
    }
}
