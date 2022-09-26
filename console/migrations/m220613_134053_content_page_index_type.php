<?php

use yii\db\Migration;

/**
 * Class m220613_134053_content_page_index_type
 */
class m220613_134053_content_page_index_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE contentPageIndexType AS ENUM ('default', 'news', 'pages', 'articles')");

        $this->addColumn(\common\models\Content::tableName(), 'page_index_type', "contentPageIndexType");

        \common\models\Content::updateAll(['page_index_type' => 'default',], ['type' => \common\models\Content::TYPE_PAGE,]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE contentPageIndexType CASCADE');

        $this->dropColumn(\common\models\Content::tableName(), 'page_index_type');
    }
}
