<?php

use common\components\helpers\ConsoleHelper;
use common\models\Catalog;
use common\models\Parser;
use yii\db\Migration;
use yii\db\Query;

/**
 * Class m210326_102347_migrate_parsers
 */
class m210326_102347_migrate_parsers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $time = time();
        $isConsole = true;
        $db = \Yii::$app->db;

        $allTotalCount = 0;
        $tableName = 'parser_autoventuri';
        $query = (new Query())->from($tableName);
        $queryCount = clone $query;
        if ($queryCount->count('*') > 0) {
            ConsoleHelper::debug('Миграция данных из '.$tableName.' в таблицу '.Parser::tableName(), $isConsole);
            ConsoleHelper::deleteParserByType(Parser::TYPE_AUTOVENTURI, $isConsole);

            $totalCount = 0;
            foreach ($query->batch(ConsoleHelper::BATCH_LIMIT) as $rows) {
                $data = [];
                foreach ($rows as $row) {
                    $data[] = [
                        Parser::TYPE_AUTOVENTURI,

                        $row['article'],
                        $row['article_our'],
                        null,
                        $row['title'],
                        $row['url'],
                        $row['brand'],
                        null, //country
                        $row['description'],
                        null, //description_ext
                        $row['characteristics'],
                        null, //links
                        $row['breadcrumbs'],
                        null, //length
                        null, //width
                        null, //height
                        null, //weight

                        $time,
                        $time,
                    ];
                }

                $count = $db->createCommand()->batchInsert(Parser::tableName(), ['type', 'article', 'article_our', 'article_1c', 'title', 'url', 'brand', 'country', 'description', 'description_ext', 'characteristics', 'links', 'breadcrumbs', 'length', 'width', 'height', 'weight', 'created_at', 'updated_at',], $data)->execute();

                ConsoleHelper::debug('Вставлено '.$count.' записей в таблицу '.Parser::tableName(), $isConsole);
                $totalCount += $count;
            }

            ConsoleHelper::debug('Всего вставлено '.$totalCount.' записей в таблицу '.Parser::tableName(), $isConsole);
            $allTotalCount += $totalCount;
        }

        ///////////////////////////////////////////////////////////////////////////////////////////

        $tableName = 'parser_triabc';
        $query = (new Query())->from($tableName);
        $queryCount = clone $query;
        if ($queryCount->count('*') > 0) {
            ConsoleHelper::debug('Миграция данных из '.$tableName.' в таблицу '.Parser::tableName(), $isConsole);
            ConsoleHelper::deleteParserByType(Parser::TYPE_TRIABC, $isConsole);

            $totalCount = 0;
            foreach ($query->batch(ConsoleHelper::BATCH_LIMIT) as $rows) {
                $data = [];
                foreach ($rows as $row) {
                    $data[] = [
                        Parser::TYPE_TRIABC,

                        $row['article'],
                        $row['article_our'],
                        null,
                        $row['title'],
                        $row['url'],
                        $row['brand'],
                        null, //country
                        $row['description'],
                        null, //description_ext
                        null, //characteristics,
                        null, //links
                        $row['breadcrumbs'],
                        null, //length
                        null, //width
                        null, //height
                        null, //weight

                        $time,
                        $time,
                    ];
                }

                $count = $db->createCommand()->batchInsert(Parser::tableName(), ['type', 'article', 'article_our', 'article_1c', 'title', 'url', 'brand', 'country', 'description', 'description_ext', 'characteristics', 'links', 'breadcrumbs', 'length', 'width', 'height', 'weight', 'created_at', 'updated_at',], $data)->execute();

                ConsoleHelper::debug('Вставлено '.$count.' записей в таблицу '.Parser::tableName(), $isConsole);
                $totalCount += $count;
            }

            ConsoleHelper::debug('Всего вставлено '.$totalCount.' записей в таблицу '.Parser::tableName(), $isConsole);
            $allTotalCount += $totalCount;
        }

        ///////////////////////////////////////////////////////////////////////////////////////////

        $tableName = 'parser_daliavto';
        $query = (new Query())->from($tableName);
        $queryCount = clone $query;
        if ($queryCount->count('*') > 0) {
            ConsoleHelper::debug('Миграция данных из '.$tableName.' в таблицу '.Parser::tableName(), $isConsole);
            ConsoleHelper::deleteParserByType(Parser::TYPE_DALIAVTO, $isConsole);

            $totalCount = 0;
            foreach ($query->batch(ConsoleHelper::BATCH_LIMIT) as $rows) {
                $data = [];
                foreach ($rows as $row) {
                    $data[] = [
                        Parser::TYPE_DALIAVTO,

                        $row['article'],
                        $row['article_our'],
                        null,
                        $row['title'],
                        $row['url'],
                        null, //brand
                        null, //country
                        null, //description
                        null, //description_ext
                        null, //characteristics,
                        null, //links
                        $row['breadcrumbs'],
                        null, //length
                        null, //width
                        null, //height
                        null, //weight

                        $time,
                        $time,
                    ];
                }

                $count = $db->createCommand()->batchInsert(Parser::tableName(), ['type', 'article', 'article_our', 'article_1c', 'title', 'url', 'brand', 'country', 'description', 'description_ext', 'characteristics', 'links', 'breadcrumbs', 'length', 'width', 'height', 'weight', 'created_at', 'updated_at',], $data)->execute();

                ConsoleHelper::debug('Вставлено '.$count.' записей в таблицу '.Parser::tableName(), $isConsole);
                $totalCount += $count;
            }

            ConsoleHelper::debug('Всего вставлено '.$totalCount.' записей в таблицу '.Parser::tableName(), $isConsole);
            $allTotalCount += $totalCount;
        }

        ConsoleHelper::debug('[ИТОГ] Всего вставлено '.$allTotalCount.' записей в таблицу '.Parser::tableName(), $isConsole);
        ConsoleHelper::debug('[ИТОГ] Затрачено '.(time() - $time).' секунд при работе с таблицей '.Parser::tableName(), $isConsole);
        ConsoleHelper::debug(PHP_EOL, $isConsole);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210326_102347_migrate_parsers cannot be reverted.\n";

        return false;
    }
}
