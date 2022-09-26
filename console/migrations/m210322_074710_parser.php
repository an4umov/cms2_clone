<?php

use yii\db\Migration;

/**
 * Class m210322_074710_parser
 */
class m210322_074710_parser extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TYPE parserType AS ENUM ('autoventuri', 'triabc', 'daliavto', 'rivalauto')");

        $this->createTable('parser', [
            'id' => $this->primaryKey(),
            'type' => "parserType",
            'article' => $this->string(255)->notNull(),
            'article_our' => $this->string(255)->notNull(),
            'article_1c' => $this->string(255),
            'title' => $this->text()->notNull(),
            'url' => $this->text()->notNull(),
            'brand' => $this->string(255),
            'country' => $this->string(255),
            'description' => $this->text()->comment('Описание товара короткое'),
            'description_ext' => $this->text()->comment('Описание товара подробное'),
            'characteristics' => $this->text()->comment('Дополнительное описание'),
            'links' => $this->text()->comment('Ссылки на файлы инструкций'),
            'breadcrumbs' => $this->text(),
            'length' => $this->float(2)->comment('длина, м'),
            'width' => $this->float(2)->comment('ширина, м'),
            'height' => $this->float(2)->comment('высота, м'),
            'weight' => $this->float(2)->comment('вес, кг'),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('parser-type-article_our-idx', 'parser', ['type', 'article_our',]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('parser-type-article_our-idx', 'parser');

        $this->execute('DROP TYPE parserType CASCADE');

        $this->execute('DROP TABLE parser CASCADE');
    }
}
