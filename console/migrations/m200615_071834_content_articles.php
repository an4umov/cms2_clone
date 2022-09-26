<?php

use yii\db\Migration;

/**
 * Class m200615_071834_content_articles
 */
class m200615_071834_content_articles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Content::tableName(), 'article_numbers', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Content::tableName(), 'article_numbers');
    }
}
