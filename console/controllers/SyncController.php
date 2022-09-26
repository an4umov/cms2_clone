<?php
namespace console\controllers;

use console\components\SyncFtp;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class SyncController
 *
 * @package console\controllers
 */
class SyncController extends Controller
{
    const SYNOLOGY_SERVER = 'limon.lr.ru';
    const SYNOLOGY_LOGIN = 'a.morozov';
    const SYNOLOGY_PASSWORD = 'land99rvr4515';

    public function actionIndex()
    {
        $ftp = new SyncFtp(self::SYNOLOGY_SERVER, self::SYNOLOGY_LOGIN, self::SYNOLOGY_PASSWORD);
        $ftp->setup(false);

        $ftp->ftpGetDir(Yii::getAlias('@files') . DIRECTORY_SEPARATOR . 'images',"/MAGAZIN/images", true, false, false);

        $ftp->close();

        return ExitCode::OK;
    }


}