<?php

use yii\db\Migration;

/**
 * Class m191115_115816_block_global_type
 */
class m191115_115816_block_global_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE blockGlobalType AS ENUM ('gallery_image','gallery_list','text_header','text_news_anons','text_news_text','text_800','banner_homepage_1_4','banner_narrow','slider_carousel')");
        $this->addColumn(\common\models\Block::tableName(), 'global_type', "blockGlobalType");
        $this->createIndex('block-global_type-unique', \common\models\Block::tableName(), 'global_type', true);

        $this->addColumn(\common\models\BlockField::tableName(), 'description', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP TYPE blockGlobalType CASCADE');
        $this->dropIndex('block-global_type-unique', \common\models\Block::tableName());

        $this->dropColumn(\common\models\Block::tableName(), 'global_type');
        $this->dropColumn(\common\models\BlockField::tableName(), 'description');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191115_115816_block_global_type cannot be reverted.\n";

        return false;
    }
    */
}
