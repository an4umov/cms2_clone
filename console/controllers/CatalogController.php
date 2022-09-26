<?php


namespace console\controllers;


use common\components\helpers\CatalogHelper;
use common\components\helpers\ConsoleHelper;
use common\models\Catalog;
use common\models\ParserLrpartsItems;
use common\models\ParserTriabc;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Query;
use yii\helpers\Console;

class CatalogController extends Controller
{
    public function actionTest()
    {
//        echo \Yii::$app->security->generatePasswordHash('Xd5hr7loJF5eiFB4CMuC');

        $user = new \amnah\yii2\user\models\User();
        $user->setScenario("admin");
        $user->email = 'manager@lr.ru';
        $user->username = 'manager';
        $user->newPassword = 'Xd5hr7loJF5eiFB4CMuC';
        $user->newPasswordConfirm = 'Xd5hr7loJF5eiFB4CMuC';
        $user->role_id = 2;
        $user->status = 1;

        if ($user->validate()) {
            $user->save(false);

            echo 'User created';
        } else {
            echo 'User not validated: '.print_r($user->getErrors(), true);
        }


        /*
        $query = (new Query())->from(ParserLrpartsItems::tableName())->select([
            'id',
            'code',
            'name',
        ]);

        $total = 0;
        foreach ($query->batch(500) as $rows) {
            foreach ($rows as $row) {
                file_put_contents('./lrparts_items.csv', implode(';', $row).PHP_EOL, FILE_APPEND);
            }

            $total += count($rows);
            echo 'Saved '.$total.' rows'.PHP_EOL;
        }*/
    }

    /**
     * @param $name
     *
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionMigrate($name = '')
    {
        ConsoleHelper::migrateCatalog($name);

        return ExitCode::OK;
    }

    /**
     * @return int
     */
    public function actionCache()
    {
        $res = \Yii::$app->cache->flush();
        if ($res) {
            ConsoleHelper::debug('Cache flushed');
        } else {
            ConsoleHelper::debug('Cache NOT flushed');
        }

        return ExitCode::OK;
    }
}