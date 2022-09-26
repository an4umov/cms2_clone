<?php


namespace console\controllers;


use common\components\helpers\CatalogHelper;
use common\components\helpers\ConsoleHelper;
use common\components\helpers\PlanFixHelper;
use common\models\CarModel;
use common\models\ParserTriabc;
use common\models\PlanfixContact;
use common\models\PlanfixPartner;
use common\models\PlanfixPartnerExt;
use common\models\PlanfixProjectTask;
use Manticoresearch\Index;
use Manticoresearch\Search;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Connection;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class PriceController extends Controller
{
    const BATCH_LIMIT = 500;

    public function actionFork()
    {
        $maxWorkers = 10;
        $cidsBatch = array();

        for ($i = 0; $i < $maxWorkers; $i++) {
            $this->forkAndFillDb($cidsBatch);
        }

        ConsoleHelper::debug('Success!');
    }

    private function forkAndFillDb(array $contentData)
    {
        $pid = pcntl_fork();
        if ($pid == -1) {
            ConsoleHelper::debug("Could not fork!");

            exit(0);
        }
        if ($pid > 0) {
            // we in parent
            return;
        }

        ConsoleHelper::debug("PID: ".$pid);

        exit(0);
    }

    public function actionSearch()
    {
        $config = ['host' => '95.216.65.244', 'port' => 9311, 'retries' => 1,];
        $client = new \Manticoresearch\Client($config);
//        $index = new Index($client,'priceIndex');
//        $index->create([
//            'supplier_id' => ['type' => 'int',],
//            'article' => ['type' => 'text',],
//            'name' => ['type' => 'text', 'options'=>['indexed'],],
//            'description' => ['type' => 'text', 'options'=>['indexed'],],
//            'price1' => ['type' => 'float',],
//        ], [
//            'rt_mem_limit' => '256M',
//            'min_infix_len' => '3',
//        ]);


        $search = new Search($client);
        $search->setIndex('priceindex');
        $search->limit(10);

//        $result = $search->search('REINHD675')->limit(10)->get();
        $result = $search->match('Акриловое стекло')->get();

        foreach ($result as $item) {
            print_r($item->getData());
        }

//        var_dump($result);

        return ExitCode::OK;
    }

    public function actionFill()
    {
        $db = \Yii::$app->db;
        /**
         * @var Connection
         */
        $dbp = \Yii::$app->dbp;

        $totalTime = time();
        $isConsole = true;
        $rowsCount = $savedCount = 0;
        $time = time();

        $query = 'select id from supplier';
        $cmd = $dbp->createCommand($query);
        $baseSuppliers = $cmd->queryColumn();

        $query = 'select id, title, value from unit';
        $cmd = $dbp->createCommand($query);
        $baseUnits = $cmd->queryAll();

        //        print_r($baseSuppliers);
        //        print_r($baseUnits);
        //        return ExitCode::OK;

        $query = (new Query())->from(ParserTriabc::tableName())->select([
            'article',
            'article_our',
            'brand',
            'title',
            'description',
            'url',
        ]);


        $baseRows = [];
        foreach ($query->batch(self::BATCH_LIMIT, $db) as $rows) {
            foreach ($rows as $row) {
                $price1 = (float)rand(100, 10000);
                $unit = $this->_getRandomValue($baseUnits);

                $baseRows[] = [
                    (int)$this->_getRandomValue($baseSuppliers),
                    $row['article_our'],
                    $row['article'],
                    $row['title'],
                    $row['brand'],
                    $price1,
                    $price1 + rand(0, 99) / 100,
                    $price1 + rand(0, 99) / 100,
                    $price1 + rand(0, 99) / 100,
                    $price1 + rand(0, 99) / 100,
                    $this->_getRandomCount($unit),
                    (int)$unit['id'],
                    mb_substr(trim($row['description']), 0, 200),
                    $row['url'] . 'image' . rand(1, 9) . '.jpg',
                    $time,
                    $time,
                ];
            }
        }

        $countBaseRows = count($baseRows);
        ConsoleHelper::debug('Количество исходных строк: ' . $countBaseRows);
        $countBaseRows--;

        ConsoleHelper::truncateTable('price', $dbp, $isConsole);

        $articleIndex = 1;
        $insertBatchCount = 1;
        $batchRows = [];
        $limit = 10000000;
        for ($i = 0; $i < $limit; $i++) {
            $randomIndex = rand(0, $countBaseRows);

            $batchRows[] = $baseRows[$randomIndex];

            if (count($batchRows) === 200) {
                $cnt = $dbp->createCommand()->batchInsert('price', [
                    'supplier_id',
                    'code',
                    'article',
                    'name',
                    'producer',
                    'price1',
                    'price2',
                    'price3',
                    'price4',
                    'price5',
                    'count',
                    'unit_id',
                    'description',
                    'image',
                    'created_at',
                    'updated_at',
                ], $batchRows)->execute();

                $batchRows = [];
                $savedCount += $cnt;

                ConsoleHelper::debug('[' . $insertBatchCount++ . '] Добавлено ' . $cnt . ' строк [' . number_format($savedCount,
                        0, '.', ' ') . '] в таблицу `price` из ' . number_format($limit, 0, '.', ' '));
            }

            $articleIndex++;
        }

        ConsoleHelper::debug('[ИТОГ] Вставлено всего ' . number_format($savedCount, 0, '.',
                ' ') . ' строк в таблицу `price`');

        $minutes = floor((time() - $totalTime) / 60);
        if ($minutes > 0) {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено минут: ' . $minutes, $isConsole);
        } else {
            ConsoleHelper::debug('[ИТОГ] Всего затрачено секунд: ' . (time() - $totalTime), $isConsole);
        }

        return ExitCode::OK;
    }

    /**
     * @param array $list
     *
     * @return mixed
     */
    private function _getRandomValue(array $list)
    {
        $cnt = count($list) - 1;

        return $list[rand(0, $cnt)];
    }

    /**
     * @param array $unit
     *
     * @return float
     */
    private function _getRandomCount(array $unit): float
    {
        $count = 0;
        switch ($unit['id']) {
            case 1:
                $count = rand(100, 10000) / 100;
                break;
            case 2:
                $count = rand(1, 100);
                break;
            case 3:
                $count = rand(1, 100) / 10;
                break;
            case 4:
                $count = rand(1000, 100000) / 100;
                break;
        }

        return floatval($count);
    }
}