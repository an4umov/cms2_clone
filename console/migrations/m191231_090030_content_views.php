<?php

use yii\db\Migration;

/**
 * Class m191231_090030_content_views
 */
class m191231_090030_content_views extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\common\models\Content::tableName(), 'views', $this->integer(11)->defaultValue(0)->notNull()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(\common\models\Content::tableName(), 'views');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191231_090030_content_views cannot be reverted.\n";

        return false;
    }
    */
}
