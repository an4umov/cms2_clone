<?php
namespace common\components\helpers;


use common\models\ArticleRecomend;
use common\models\Articles;
use common\models\CarModel;
use common\models\Catalog;
use common\models\CatalogLinktagDepartment;
use common\models\CatRecomend;
use common\models\Cross;
use common\models\FullPrice;
use common\models\Parser;
use common\models\ParserLrpartsItems;
use common\models\PriceList;
use common\models\Prices;
use common\models\ReclamaStatus;
use common\models\RemnantsOfGoods;
use common\models\Replacements;
use common\models\SpecialOffers;
use frontend\components\widgets\CatalogListWidget;
use yii\db\Query;

class ConsoleHelper
{
    const WEBHOOK_KEY_CONTRACTOR_1C = 'gPTQtLrXWesgJIds0eS5j8S93PaTuHWG';

    const BATCH_LIMIT = 300;
    const BATCH_LIMIT_100 = 100;

    const MIGRATE_CATALOG = 'catalog';
    const MIGRATE_PRICE_LIST = 'price_list';
    const MIGRATE_CAR_MODELS = 'car_models';
    const MIGRATE_ARTICLES = 'articles';
    const MIGRATE_ARTICLE_RECOMEND = 'article_recomend';
    const MIGRATE_CAT_RECOMEND = 'cat_recomend';
    const MIGRATE_CROSS = 'cross';
    const MIGRATE_PRICES = 'prices';
    const MIGRATE_REMNANTS_OF_GOODS = 'remnants_of_goods';
    const MIGRATE_REPLACEMENTS = 'replacements';
    const MIGRATE_SPECIAL_OFFERS = 'special_offers';
    const MIGRATE_RECLAMA_STATUS = 'reclama_status';
    const MIGRATE_TEST = 'test';
    const MIGRATE_TEST2 = 'test2';

    const MIGRATIONS = [
        self::MIGRATE_CATALOG,
        self::MIGRATE_PRICE_LIST,
        self::MIGRATE_CAR_MODELS,
        self::MIGRATE_ARTICLES,
        self::MIGRATE_ARTICLE_RECOMEND,
        self::MIGRATE_CAT_RECOMEND,
        self::MIGRATE_CROSS,
        self::MIGRATE_PRICES,
        self::MIGRATE_REMNANTS_OF_GOODS,
        self::MIGRATE_REPLACEMENTS,
        self::MIGRATE_SPECIAL_OFFERS,
        self::MIGRATE_RECLAMA_STATUS,
    ];

    private static $_debugMessages;

    /**
     * @param      $message
     * @param bool $isConsole
     * @param bool $isError
     */
    public static function debug($message, $isConsole = true, $isError = false) : void
    {
        $msg = '['.date('H:i:s'). '] '.$message.PHP_EOL;
        if ($isConsole) {
            echo $msg;
            if ($isError) {
                file_put_contents('console_errors.log', $message, FILE_APPEND);
            }
        } else {
            if ($message !== PHP_EOL) {
                self::$_debugMessages[] = $msg;
            }
        }

        return;
    }

    /**
     * @param string $name
     * @param bool   $isConsole
     *
     * @return array|null
     * @throws \yii\db\Exception
     */
    public static function migrateCatalog(string $name = '', $isConsole = true)
    {
        $db = \Yii::$app->db;
        $externalDb = \Yii::$app->db2;
        $totalTime = time();
        self::$_debugMessages = [];

        // Catalog
        if (empty($name) || $name === self::MIGRATE_CATALOG) {
            $time = time();
            $tableName = '{{shop.catalog}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(Catalog::tableName(), $db, $isConsole);

                $cache = \Yii::$app->cache;
                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            (int) $row['hierarchy_level'],
                            (int) $row['is_product'],
                            $row['parent_code'],
                            !empty($row['item_order']) ? $row['item_order'] : 0,
                            $row['item_code'],
                            $row['item_name'],
                            $row['item_full_name'],
                            $row['description'],
                            $row['title'],
                            $row['tags'],
                            $row['article_number'],
                            $row['dept'],
                            $row['copy_of'],
                            $row['link_anchor'],
                            $row['link_tag'],
                            $row['tag_for_link'],
                            $time,
                            $time,
                        ];

                        $key = CatalogListWidget::CACHE_TREE_KEY.'_'.$row['item_code'];
                        if ($cache->exists($key)) {
                            $cache->delete($key);
                        }
                    }

                    $count = $db->createCommand()->batchInsert(Catalog::tableName(), ['level', 'is_product', 'parent_code', 'order', 'code', 'name', 'full_name', 'description', 'title', 'tags', 'article', 'is_department', 'copy_of', 'link_anchor', 'link_tag', 'tag_for_link', 'created_at', 'updated_at',], $data)->execute();

                    self::debug('Вставлено '.$count.' записей в таблицу '.$tableName, $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено '.$totalCount.' записей в таблицу '.$tableName, $isConsole);

                $key = CatalogListWidget::CACHE_CATALOG_STRUCTURE_DATA;
                if ($cache->exists($key)) {
                    $cache->delete($key);
                }
            }

            self::debug('Затрачено '.(time() - $time).' секунд при работе с таблицей '.$tableName, $isConsole);
            self::debug(PHP_EOL, $isConsole);

            $count = CatalogHelper::fillCatalogLinktagDepartment();
            self::debug('Создано '.$count.' записей в таблице '.CatalogLinktagDepartment::tableName(), $isConsole);

            $result = CatalogHelper::analyzeCatalogDepartments();
            self::debug('Найдено '.count($result['notFound']).' новых департаментов, которых нет в админке', $isConsole);

            if (!empty($result['notFound'])) {
                $departmentsSaved = CatalogHelper::addNewDepartmentsFromCatalog($result['notFound'], $isConsole);

                self::debug('Создано '.$departmentsSaved.' новых департаментов из '.count($result['notFound']).' найденных', $isConsole);
            }

            self::debug('Найдено '.count($result['broken']).' сломанных департаментов в админке, которые нужно поправить', $isConsole);
        }

        // Price_list
        if (empty($name) || $name === self::MIGRATE_PRICE_LIST) {
            $time = time();
            $tableName = '{{shop.price_list}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(PriceList::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            $row['price_list_code'],
                            $row['kross_type'],
                            $row['article_number'],
                            $row['product_code'],
                            $row['manufacturer'],
                            $row['quality'],
                            $row['price'],
                            $row['availability'],
                            $row['commentary'],
                            $row['multiplicity'],
                            CatalogHelper::generatePriceListKey($row),
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(PriceList::tableName(), ['code', 'cross_type', 'article_number', 'product_code', 'manufacturer', 'quality', 'price', 'availability', 'commentary', 'multiplicity', 'key', 'created_at', 'updated_at',], $data)->execute();

                    self::debug('Вставлено '.$count.' записей в таблицу '.PriceList::tableName(), $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено '.$totalCount.' записей в таблицу '.PriceList::tableName(), $isConsole);
            }

            self::debug('Затрачено '.(time() - $time).' секунд при работе с таблицей '.PriceList::tableName(), $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        // car_models
        if (empty($name) || $name === self::MIGRATE_CAR_MODELS) {
            $time = time();
            $tableName = '{{shop.car_models}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(CarModel::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            $row['id'],
                            $row['parent_id'],
                            $row['level'],
                            $row['name'],
                            $row['cirillic_name'],
                            $row['alias'],
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(CarModel::tableName(), ['id', 'parent_id', 'level', 'name', 'cirillic_name', 'alias', 'created_at', 'updated_at',], $data)->execute();

                    self::debug('Вставлено '.$count.' записей в таблицу '.CarModel::tableName(), $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено '.$totalCount.' записей в таблицу '.CarModel::tableName(), $isConsole);
            }

            self::debug('Затрачено '.(time() - $time).' секунд при работе с таблицей '.CarModel::tableName(), $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }


        //Articles
        if (empty($name) || $name === self::MIGRATE_ARTICLES) {
            $items = [];

            $query = (new Query())->from(ParserLrpartsItems::tableName())->select(['id', 'code',]);
            foreach ($query->batch(1000) as $rows) {
                foreach ($rows as $row) {
                    $items[strtolower($row['code'])] = $row['id'];
                }
            }

            $time = time();
            $tableName = '{{shop.articles}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(Articles::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $isInEpc = false;
                        if (isset($items[strtolower($row['article_number'])])) {
                            $isInEpc = true;
                        }

                        $data[] = [
                            $row['article_number'],
                            $row['article_name'],
                            $row['article_description'],
                            $row['title'],
                            $row['stock'],
                            $isInEpc,
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(Articles::tableName(),
                        ['number', 'name', 'description', 'title', 'is_in_stock', 'is_in_epc', 'created_at', 'updated_at',], $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . $tableName, $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . $tableName, $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $tableName, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //article_recomend
        if (empty($name) || $name === self::MIGRATE_ARTICLE_RECOMEND) {
            $time = time();
            $tableName = '{{shop.article_recomend}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(ArticleRecomend::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $articles = explode(',', $row['article']);
                        foreach ($articles as $i => $article) {
                            $articles[$i] = trim($article);
                        }

                        $data[] = [
                            $row['for_article'],
                            $row['recomendation'],
                            implode(',', $articles),
                            $row['comment'],
                            $row['color'],
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(ArticleRecomend::tableName(),
                        ['number', 'recomendation', 'articles', 'comment', 'color', 'created_at', 'updated_at',], $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . ArticleRecomend::tableName(), $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . ArticleRecomend::tableName(), $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . ArticleRecomend::tableName(), $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //cat_recomend
        if (empty($name) || $name === self::MIGRATE_CAT_RECOMEND) {
            $time = time();
            $tableName = '{{shop.cat_recomend}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(CatRecomend::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            $row['cat'],
                            $row['recomend_cat'],
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(CatRecomend::tableName(),
                        ['cat', 'recomend_cat', 'created_at', 'updated_at',], $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . CatRecomend::tableName(), $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . CatRecomend::tableName(), $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . CatRecomend::tableName(), $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //cross
        if (empty($name) || $name === self::MIGRATE_CROSS) {
            $time = time();
            $tableName = '{{shop.cross}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(Cross::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            $row['line'],
                            $row['superarticle'],
                            $row['brand_code'],
                            $row['brand_name'],
                            $row['group_code'],
                            $row['group_name'],
                            $row['article'],
                            $row['article_name'],
                            $row['comment'],
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(Cross::tableName(),
                        ['line', 'superarticle', 'brand_code', 'brand_name', 'group_code', 'group_name', 'article', 'article_name', 'comment', 'created_at', 'updated_at',], $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . Cross::tableName(), $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . Cross::tableName(), $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . Cross::tableName(), $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //Full_price
        /*
        if (empty($name) || $name === 'full_price') {
            $time = time();
            $tableName = '{{shop.full_price}}';
            $query = (new Query())->from($tableName)->where("price_list_code != ''");
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(FullPrice::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            $row['price_list_code'],
                            $row['partner'],
                            $row['article_number'],
                            $row['product_code'],
                            $row['manufacturer'],
                            $row['quality'],
                            $row['product_name'],
                            (float)$row['price'],
                            $row['sale'],
                            (float)$row['price_discount'],
                            (float)$row['price_opt'],
                            $row['availability'],
                            $row['delivery'],
                            $row['delivery_time'],
                            $row['commentary'],
                            (float)$row['multiplicity'],
                            $row['commentary2'],
                            $row['type_price_list'],
                            $row['color'],
                            $row['group_price_list'],
                            $row['group_price_list_color'],
                            $row['sale_color'],
                            CatalogHelper::generateFullPriceKey($row),
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(FullPrice::tableName(), [
                        'price_list_code',
                        'partner',
                        'article_number',
                        'product_code',
                        'manufacturer',
                        'quality',
                        'product_name',
                        'price',
                        'sale',
                        'price_discount',
                        'price_opt',
                        'availability',
                        'delivery',
                        'delivery_time',
                        'commentary',
                        'multiplicity',
                        'commentary2',
                        'type_price_list',
                        'color',
                        'group_price_list',
                        'group_price_list_color',
                        'sale_color',
                        'key',
                        'created_at',
                        'updated_at',
                    ], $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . $tableName, $isConsole);
                    $totalCount += $count;
                }

                
                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . $tableName, $isConsole);
            }

            
            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $tableName, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }
        */

        //Prices
        if (empty($name) || $name === self::MIGRATE_PRICES) {
            $time = time();
            $tableName = '{{shop.prices}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(Prices::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            !empty($row['product_code']) ?: '',
                            !empty($row['article_number']) ?: '',
                            !empty($row['product_name']) ?: '',
                            (float)!empty($row['price']) ?: 0,
                            (int)!empty($row['sale']) ?: 0,
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(Prices::tableName(), [
                        'product_code',
                        'article_number',
                        'product_name',
                        'price',
                        'sale',
                        'created_at',
                        'updated_at',
                    ], $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . $tableName, $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . $tableName, $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $tableName, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //Remnants_of_goods
        if (empty($name) || $name === self::MIGRATE_REMNANTS_OF_GOODS) {
            $time = time();
            $tableName = '{{shop.remnants_of_goods}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(RemnantsOfGoods::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            !empty($row['product_code']) ?: '',
                            $row['article_number'],
                            $row['product_name'],
                            (int)$row['quantity'],
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(RemnantsOfGoods::tableName(),
                        ['product_code', 'article_number', 'product_name', 'quantity', 'created_at', 'updated_at',],
                        $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . $tableName, $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . $tableName, $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $tableName, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //Replacements
        if (empty($name) || $name === self::MIGRATE_REPLACEMENTS) {
            $time = time();
            $tableName = '{{shop.replacements}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(Replacements::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        $data[] = [
                            $row['type_id'],
                            $row['article_id'],
                            $row['article_number'],
                            (int)!empty($row['current_replacement']) ?: 0,
                            $time,
                            $time,
                        ];
                    }

                    $count = $db->createCommand()->batchInsert(Replacements::tableName(),
                        ['type_id', 'article_id', 'article_number', 'current_replacement', 'created_at', 'updated_at',],
                        $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . $tableName, $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . $tableName, $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $tableName, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //SpecialOffers
        if (empty($name) || $name === self::MIGRATE_SPECIAL_OFFERS) {
            $time = time();
            $tableName = '{{shop.special_offers}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            $skipped = 0;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(SpecialOffers::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        if (!empty($row['article_number']) && !empty($row['product_code']) && !empty($row['offer_type']) && !empty($row['offer_name'])) {
                            $data[] = [
                                $row['article_number'],
                                $row['product_code'],
                                $row['title'],
                                $row['product_name'],
                                $row['offer_type'],
                                $row['offer_name'],
                                $time,
                                $time,
                            ];
                        } else {
                            $skipped++;
                        }
                    }

                    $count = $db->createCommand()->batchInsert(SpecialOffers::tableName(), [
                        'article_number',
                        'product_code',
                        'title',
                        'product_name',
                        'offer_type',
                        'offer_name',
                        'created_at',
                        'updated_at',
                    ], $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . $tableName, $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . $tableName, $isConsole);
                self::debug('Пропущено ' . $skipped . ' записей для таблицы ' . $tableName, $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $tableName, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //ReclamaStatus
        if (empty($name) || $name === self::MIGRATE_RECLAMA_STATUS) {
            $time = time();
            $tableName = '{{shop.reclama_status}}';
            $query = (new Query())->from($tableName);
            $queryCount = clone $query;
            $skipped = 0;
            if ($queryCount->count('*', $externalDb) > 0) {
                self::truncateTable(ReclamaStatus::tableName(), $db, $isConsole);

                $totalCount = 0;
                foreach ($query->batch(self::BATCH_LIMIT, $externalDb) as $rows) {
                    $data = [];
                    foreach ($rows as $row) {
                        if (!empty($row['status_code']) && !empty($row['status_name']) && !empty($row['status_type'])) {
                            $data[] = [
                                $row['status_code'],
                                $row['status_name'],
                                $row['status_type'],
                                $row['status_color'],
                                $row['status_description'],
                                $time,
                                $time,
                            ];
                        } else {
                            $skipped++;
                        }
                    }

                    $count = $db->createCommand()->batchInsert(ReclamaStatus::tableName(),
                        ['code', 'name', 'type', 'color', 'description', 'created_at', 'updated_at',],
                        $data)->execute();

                    self::debug('Вставлено ' . $count . ' записей в таблицу ' . $tableName, $isConsole);
                    $totalCount += $count;
                }

                self::debug('Всего вставлено ' . $totalCount . ' записей в таблицу ' . $tableName, $isConsole);
                self::debug('Пропущено ' . $skipped . ' записей для таблицы ' . $tableName, $isConsole);
            }

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $tableName, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //TEST
        if ($name === self::MIGRATE_TEST) {
            $time = time();

            self::debug('Вставлено ' . rand(1, 1000) . ' записей в таблицу ' . $name, $isConsole);

            self::debug('Всего вставлено ' . rand(1, 1000) . ' записей в таблицу ' . $name, $isConsole);
            self::debug('Пропущено ' . rand(1, 1000) . ' записей для таблицы ' . $name, $isConsole);

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $name, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        //TEST 2
        if ($name === self::MIGRATE_TEST2) {
            $time = time();

            self::debug('Вставлено ' . rand(1, 1000) . ' записей в таблицу ' . $name, $isConsole);

            self::debug('Всего вставлено ' . rand(1, 1000) . ' записей в таблицу ' . $name, $isConsole);
            self::debug('Пропущено ' . rand(1, 1000) . ' записей для таблицы ' . $name, $isConsole);

            self::debug('Затрачено ' . (time() - $time) . ' секунд при работе с таблицей ' . $name, $isConsole);
            self::debug(PHP_EOL, $isConsole);
        }

        if ($isConsole) {
            self::debug('#######################################################################', $isConsole);
        }
        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            self::debug('Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            self::debug('Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        self::debug(PHP_EOL, $isConsole);

        if (!$isConsole) {
            return self::$_debugMessages;
        }

        return null;
    }

    /**
     * @param string $tableName
     * @param        $db
     * @param bool   $isConsole
     *
     * @return int
     * @throws \yii\db\Exception
     */
    public static function truncateTable(string $tableName, $db, $isConsole = true) : int
    {
        $count = (new Query())->createCommand($db)->truncateTable($tableName)->execute();

        self::debug('Очистка таблицы '.$tableName, $isConsole);

        return $count;
    }

    /**
     * @param string $type
     * @param bool   $isConsole
     *
     * @return bool|int
     */
    public static function deleteParserByType(string $type, $isConsole = true)
    {
        if (in_array($type, Parser::TYPES)) {
            ConsoleHelper::debug('Очистка таблицы '.Parser::tableName().' по типу "'.$type.'"', $isConsole);

            return Parser::deleteAll(['type' => $type,]);
        }

        return false;
    }

    /**
     * @param bool $isConsole
     *
     * @return null
     * @throws PlanFixHelperException
     * @throws \yii\db\Exception
     */
    public static function processPlanFixHandbooks($isConsole = true)
    {
        /* @var \yii\db\Connection $externalDb */
        $externalDb = \Yii::$app->db2;
        $totalTime = time();

        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials(PlanFixHelper::LOGIN, PlanFixHelper::PASSWORD);
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        //        $structureContractor1C = $api->api('handbook.getStructure', ['handbook' => ['id' => PlanFixHelper::HANDBOOK_CONTRACTOR_1C_ID,],]);
        //        print_r($structureContractor1C);
        //        return ExitCode::OK;


        $handbooks = [
            PlanFixHelper::HANDBOOK_CONTRACTOR_1C_ID => ['title' => PlanFixHelper::HANDBOOK_CONTRACTOR_1C_TITLE, 'table' => PlanFixHelper::HANDBOOK_CONTRACTOR_1C_TABLE,],
        ];

        foreach ($handbooks as $handbookID => $handbookData) {
            ConsoleHelper::debug('Начало синхронизации справочника "'.$handbookData['title'].'"', $isConsole);

            $externalTableName = $handbookData['table'];
            $command = (new \yii\db\Query())
                ->select(['code', 'name', 'name_official', 'address', 'buyer', 'supplier', 'type',])
                ->from($externalTableName)
                ->createCommand();
            $command->db = $externalDb;
            $rows = $command->queryAll();
            foreach ($rows as $row) {
                $row[PlanFixHelper::HANDBOOK_ARCHIVED] = 0;
                $existDbRows[$row['code']] = $row;
            }
            unset($rows);

            ConsoleHelper::debug('Получено строк справочника из БД: '.count($existDbRows), $isConsole);

            $existPlanFixRows = [];
            $pageCurrent = 1;
            do {
                $records = $api->api('handbook.getRecords', ['handbook' => ['id' => $handbookID,], 'pageCurrent' => $pageCurrent, 'pageSize' => self::BATCH_LIMIT_100,]);
                $pageCurrent++;

                if (!empty($records[PlanFixHelper::KEY_DATA]['records'])) {
                    if (!isset($records[PlanFixHelper::KEY_DATA]['records']['record'][0])) {
                        $record = $records[PlanFixHelper::KEY_DATA]['records']['record'];
                        $records[PlanFixHelper::KEY_DATA]['records']['record'] = [];
                        $records[PlanFixHelper::KEY_DATA]['records']['record'][] = $record;
                    }

                    foreach ($records[PlanFixHelper::KEY_DATA]['records']['record'] as $index => $record) {
                        $planFixRow = [PlanFixHelper::HANDBOOK_KEY => $record[PlanFixHelper::HANDBOOK_KEY], PlanFixHelper::HANDBOOK_ARCHIVED => $record[PlanFixHelper::HANDBOOK_ARCHIVED],];
                        foreach ($record['customData']['customValue'] as $customValue) {
                            switch ($customValue['field']['id']) {
                                case PlanFixHelper::HANDBOOK_CONTRACTOR_1C_CODE_ID:
                                    $planFixRow[PlanFixHelper::HANDBOOK_CONTRACTOR_1C_CODE_NAME] = self::_getCustomValue($customValue['value']);
                                    break;
                                case PlanFixHelper::HANDBOOK_CONTRACTOR_1C_NAME_ID:
                                    $planFixRow[PlanFixHelper::HANDBOOK_CONTRACTOR_1C_NAME_NAME] = self::_getCustomValue($customValue['value']);
                                    break;
                                case PlanFixHelper::HANDBOOK_CONTRACTOR_1C_NAME_OFFICIAL_ID:
                                    $planFixRow[PlanFixHelper::HANDBOOK_CONTRACTOR_1C_NAME_OFFICIAL_NAME] = self::_getCustomValue($customValue['value']);
                                    break;
                                case PlanFixHelper::HANDBOOK_CONTRACTOR_1C_ADDRESS_ID:
                                    $planFixRow[PlanFixHelper::HANDBOOK_CONTRACTOR_1C_ADDRESS_NAME] = self::_getCustomValue($customValue['value']);
                                    break;
                                case PlanFixHelper::HANDBOOK_CONTRACTOR_1C_BUYER_ID:
                                    $planFixRow[PlanFixHelper::HANDBOOK_CONTRACTOR_1C_BUYER_NAME] = self::_getCustomValue($customValue['value']);
                                    break;
                                case PlanFixHelper::HANDBOOK_CONTRACTOR_1C_SUPPLIER_ID:
                                    $planFixRow[PlanFixHelper::HANDBOOK_CONTRACTOR_1C_SUPPLIER_NAME] = self::_getCustomValue($customValue['value']);
                                    break;
                                case PlanFixHelper::HANDBOOK_CONTRACTOR_1C_TYPE_ID:
                                    $planFixRow[PlanFixHelper::HANDBOOK_CONTRACTOR_1C_TYPE_NAME] = self::_getCustomValue($customValue['value']);
                                    break;
                            }
                        }

                        $existPlanFixRows[$planFixRow['code']] = $planFixRow;
                    }
                } else {
                    break;
                }
            } while (count($records[PlanFixHelper::KEY_DATA]['records']) > 0);

            ConsoleHelper::debug('Получено страниц справочника: '.($pageCurrent-2), $isConsole);
            ConsoleHelper::debug('Получено записей справочника: '.count($existPlanFixRows), $isConsole);
            ConsoleHelper::debug('Начало сравнения двух источников...', $isConsole);

            $planFixAdd = $planFixUpdate = [];
            foreach ($existDbRows as $existDbCode => $existDbRow) {
                if (isset($existPlanFixRows[$existDbCode])) {
                    foreach ($existPlanFixRows[$existDbCode] as $field => $value) {
                        if ($field === PlanFixHelper::HANDBOOK_KEY) {
                            continue;
                        }

                        if ($existDbRow[$field] != $value) {
                            $planFixUpdate[$existPlanFixRows[$existDbCode][PlanFixHelper::HANDBOOK_KEY]][$field] = $existDbRow[$field];
                        }
                    }

                    unset($existPlanFixRows[$existDbCode]);
                } else {
                    unset($existDbRow[PlanFixHelper::HANDBOOK_KEY]);

                    $planFixAdd[$existDbCode] = $existDbRow;
                }
            }

            $invertHandbookContractor1cFields = array_flip(PlanFixHelper::HANDBOOK_CONTRACTOR_1C_FIELDS);

            //ДОБАВЛЕНИЕ
            ConsoleHelper::debug('Подлежит добавлению записей в справочник PlanFix: '.count($planFixAdd), $isConsole);

            $addedCount = 0;
            foreach ($planFixAdd as $dbCode => $dbData) {
                $customValues = [];
                foreach ($dbData as $field => $value) {
                    if (isset($invertHandbookContractor1cFields[$field])) {
                        $customValues[] = ['id' => $invertHandbookContractor1cFields[$field], 'value' => $value,];
                    }
                }

                $params = [
                    'handbook' => ['id' => $handbookID,],
                    'isGroup' => false,
                    PlanFixHelper::HANDBOOK_ARCHIVED => false,
                    'customData' => [
                        'customValue' => $customValues,
                    ],
                ];

                $result = $api->api('handbook.addRecord', $params);
                if (!empty($result['success'])) {
                    $addedCount++;
                }
            }

            if ($planFixAdd) {
                ConsoleHelper::debug('Добавлено записей в справочнике PlanFix: '.$addedCount, $isConsole);
            }

            //ОБНОВЛЕНИЕ
            ConsoleHelper::debug('Подлежит обновлению записей в справочнике PlanFix: '.count($planFixUpdate), $isConsole);
            $updatedCount = 0;
            foreach ($planFixUpdate as $key => $planFixUpdateData) {
                $customValues = [];
                foreach ($planFixUpdateData as $field => $value) {
                    if (isset($invertHandbookContractor1cFields[$field])) {
                        $customValues[] = ['id' => $invertHandbookContractor1cFields[$field], 'value' => $value,];
                    }
                }

                $params = [
                    'handbook' => ['id' => $handbookID,],
                    'key' => $key,
                    'customData' => [
                        'customValue' => $customValues,
                    ],
                ];

                $result = $api->api('handbook.updateRecord', $params);
                if (!empty($result['success'])) {
                    $updatedCount++;
                }
            }
            if ($planFixUpdate) {
                ConsoleHelper::debug('Обновлено записей в справочнике PlanFix: '.$updatedCount, $isConsole);
            }

            //УДАЛЕНИЕ
            ConsoleHelper::debug('Подлежит удалению записей в справочнике PlanFix: '.count($existPlanFixRows), $isConsole);
            if ($existPlanFixRows) {
                $deletedCount = 0;
                foreach ($existPlanFixRows as $existPlanFixRow) {
                    if (empty($existPlanFixRow[PlanFixHelper::HANDBOOK_ARCHIVED])) {
                        $params = [
                            'handbook' => ['id' => $handbookID,],
                            'key' => $existPlanFixRow[PlanFixHelper::HANDBOOK_KEY],
                            PlanFixHelper::HANDBOOK_ARCHIVED => true,
                        ];

                        $result = $api->api('handbook.updateRecord', $params);
                        if (!empty($result['success'])) {
                            $deletedCount++;
                        }
                    } else {
                        ConsoleHelper::debug('Запись в справочнике PlanFix уже удалена. Пропуск...', $isConsole);
                    }
                }

                ConsoleHelper::debug('Удалено записей в справочнике PlanFix: '.$deletedCount, $isConsole);
            }
        }

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('Всего затрачено минут: '.$minutes, $isConsole);
        } else {
            ConsoleHelper::debug('Всего затрачено секунд: '.(time() - $totalTime), $isConsole);
        }

        if (!$isConsole) {
            return self::$_debugMessages;
        }

        return null;
    }

    /**
     * @param $customValue
     *
     * @return |null
     */
    private static function _getCustomValue($customValue)
    {
        if (is_array($customValue)) {
            return null;
        }

        return $customValue;
    }
}
