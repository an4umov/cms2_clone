<?php
namespace common\components\helpers;



use backend\components\helpers\MenuHelper;
use common\models\Articles;
use common\models\Catalog;
use common\models\ParserLrpartsItems;
use common\models\ParserLrpartsRubrics;
use yii\db\Query;
use yii\helpers\Json;
use yii\web\JsExpression;

class ParserHelper
{
    const BREAK_TEXT = 'ВЫГОДНОЕ предложение';
    const TYPE_RUBRIC = 'rubric';
    const IMAGES_PATH = '/img/Parsing/';
    const IMAGES_PATH_LRPARTS = self::IMAGES_PATH.'lrparts.ru/';

    const CACHE_KEY_LRPARTS = 'lrparts-tree-data';
    const CACHE_KEY_LRPARTS_RUBRICS = 'lrparts-rubrics-data';
    const CACHE_DURATION_LRPARTS = 3600 * 24;

    /**
     * @param $str
     *
     * @return string
     */
    public static function transliterate($str) : string
    {
        $rusToEng = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'j',
            'з' => 'z',
            'и' => 'i',
            'й' => 'i',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sc',
            'ъ' => '',
            'ы' => 'y',
            'ь' => '',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9',
            'a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd', 'e' => 'e', 'f' => 'f', 'g' => 'g', 'h' => 'h', 'i' => 'i', 'j' => 'j',
            'k' => 'k', 'l' => 'l', 'm' => 'm', 'n' => 'n', 'o' => 'o', 'p' => 'p', 'q' => 'q', 'r' => 'r', 's' => 's', 't' => 't',
            'u' => 'u', 'v' => 'v', 'w' => 'w', 'x' => 'x', 'y' => 'y', 'z' => 'z',
        ];
        $str = mb_convert_case($str, MB_CASE_LOWER);
        $strChanged = '';

//        foreach (preg_split('//u', $str) as $char) {
        foreach (preg_split('//u', $str, -1) as $char) {
            if ($char === '') {
                continue;
            }

            if (isset($rusToEng[$char])) {
                $strChanged .= $rusToEng[$char];
            }
        }

        $strChanged = str_replace(' ', '_', $strChanged);

        return $strChanged;
    }

    /**
     * @param $str
     *
     * @return string
     */
    public static function letters2digits($str) : string
    {
        $letter2digit = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => 4,
            'e' => 5,
            'f' => 6,
            'g' => 7,
            'h' => 8,
            'i' => 9,
            'j' => 10,
            'k' => 11,
            'l' => 12,
            'm' => 13,
            'n' => 14,
            'o' => 15,
            'p' => 16,
            'q' => 17,
            'r' => 18,
            's' => 19,
            't' => 20,
            'u' => 21,
            'v' => 22,
            'w' => 23,
            'x' => 24,
            'y' => 25,
            'z' => 26,
        ];
        $strChanged = '';

//        foreach (preg_split('//u', $str) as $char) {
        foreach (preg_split('//u', $str, -1) as $char) {
            if ($char === '') {
                continue;
            }

            if (isset($letter2digit[$char])) {
                $strChanged .= $letter2digit[$char];
            } else {
                $strChanged .= $char;
            }
        }

        return $strChanged;
    }

    /**
     * @param $str
     *
     * @return string
     */
    public static function parseArticleNumber($str) : string
    {
        $rusToEng = [
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'J',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'I',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'CH',
            'Ш' => 'SH',
            'Щ' => 'SC',
            'Ъ' => '',
            'Ы' => 'Y',
            'Ь' => '',
            'Э' => 'E',
            'Ю' => 'YU',
            'Я' => 'YA',
            '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9',
            'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H', 'I' => 'I', 'J' => 'J',
            'K' => 'K', 'L' => 'L', 'M' => 'M', 'N' => 'N', 'O' => 'O', 'P' => 'P', 'Q' => 'Q', 'R' => 'R', 'S' => 'S', 'T' => 'T',
            'U' => 'U', 'V' => 'V', 'W' => 'W', 'X' => 'X', 'Y' => 'Y', 'Z' => 'Z',
        ];
        $str = mb_convert_case($str, MB_CASE_UPPER);
        $strChanged = '';

//        foreach (preg_split('//u', $str) as $char) {
        foreach (preg_split('//u', $str, -1) as $char) {
            if ($char === '') {
                continue;
            }

            if (isset($rusToEng[$char])) {
                $strChanged .= $rusToEng[$char];
            } else {
                $strChanged .= '-';
            }
        }

        return $strChanged;
    }

    /**
     * @param $str
     *
     * @return string
     */
    public static function parseDescription($str) : string
    {
        $index = mb_stripos($str, self::BREAK_TEXT);
        if ($index !== false) {
            $str = mb_substr($str, 0, $index);
        }

        return trim($str);
    }

    /**
     * @param string $url
     *
     * @return false|string|null
     */
    public static function getRemoteContent(string $url)
    {
        $data = null;
        $count = 1;
        $sleep = 0.5;

        while (empty($data) && $count <= 3) {
            try {
                $data = file_get_contents($url);

                break;
            } catch (\Exception $e) {
                ConsoleHelper::debug('Попытка #'.$count.'. Ошибка: '.$e->getMessage().'. Пауза на '.$sleep.' секунд...', true);
                sleep($sleep);
                $count++;
                $sleep *= 2;
                continue;
            }
        }

        return $data;
    }

    /**
     * @param string $url
     *
     * @return false|string|null
     */
    public static function getRemoteContentSSL(string $url)
    {
        $data = null;
        $count = 1;
        $sleep = 0.5;

        $arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
                "cafile" => \Yii::getAlias("@files").DIRECTORY_SEPARATOR.'cacert.pem',
            ],
        ];

        while (empty($data) && $count <= 3) {
            try {
                $data = file_get_contents($url, false, stream_context_create($arrContextOptions));

                break;
            } catch (\Exception $e) {
                ConsoleHelper::debug('Попытка #'.$count.'. Ошибка: '.$e->getMessage().'. Пауза на '.$sleep.' секунд...', true);
                sleep($sleep);
                $count++;
                $sleep *= 2;
                continue;
            }
        }

        return $data;
    }

    /**
     * @param string $url
     *
     * @return bool|string
     */
    public static function fileGetContentsCurl(string $url )
    {
        $ua = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000); // 3 sec.
        curl_setopt($ch, CURLOPT_TIMEOUT, 10000); // 10 sec.
        curl_setopt($ch, CURLOPT_CAINFO, \Yii::getAlias("@files").DIRECTORY_SEPARATOR.'cacert.pem');

        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close( $ch );

        if (empty($data)) {
            ConsoleHelper::debug('Не удалось загрузить '.$url.'. Ошибка: '.print_r($error, true), true);
        }

        return $data;
    }

    /**
     * @param string $value
     *
     * @return float
     */
    public static function parseFloat(string $value) : float
    {
        if (is_numeric($value)) {
            return floatval($value);
        }

        $int = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);

        return floatval($int);
    }

    /**
     * @param $url
     *
     * @return bool|string
     */
    public static function getRemoteContentCurl($url) {
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION,CURL_SSLVERSION_DEFAULT);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if (empty($data)) {
            ConsoleHelper::debug('Не удалось загрузить '.$url.'. Ошибка: '.print_r($error, true), true);
        }

        return $data;
    }

    /**
     * @return string
     */
    public static function getLrpartsImagesRootPath() : string
    {
        return \Yii::getAlias('@backendImages').DIRECTORY_SEPARATOR.'Parsing'.DIRECTORY_SEPARATOR.'lrparts.ru';
    }

    /**
     * @return array
     */
    public static function getLrpartsTreeData() : array
    {
        $cache = \Yii::$app->cache;
        $key = self::CACHE_KEY_LRPARTS;
//        $cache->delete($key);

        return $cache->getOrSet($key, function () {
            $rootItem = ['name' => 'Запчасти', 'id' => 0, 'url' => '', 'open' => true, 'type' => DepartmentHelper::TYPE_ROOT, Catalog::TREE_ITEM_CHILDREN => [],];

            $topRubrics = ParserLrpartsRubrics::find()->where(['parent_id' => 0,])->orderBy(['sort_field' => SORT_ASC,])->indexBy('id')->asArray()->all();
            $otherRubrics = ParserLrpartsRubrics::find()->where(['>', 'parent_id', 0])->orderBy(['parent_id' => SORT_ASC, 'sort_field' => SORT_ASC,])->indexBy('id')->asArray()->all();

            foreach ($topRubrics as $rubricID => $rubric) {
                $rootItem[Catalog::TREE_ITEM_CHILDREN][] = [
                    'id' => $rubricID,
                    'name' => $rubric['name'],
                    'url' => '/'.MenuHelper::FIRST_MENU_PARSING.'/'.MenuHelper::SECOND_MENU_PARSING_LRPARTS.'/view?id='.$rubricID,
                    'type' => self::TYPE_RUBRIC,
                    'font' => !empty($rubric['is_last']) ? '{color:#a7a7a7;}' : '',
                    'is_last' => $rubric['is_last'],
                    'title' => $rubric['title'],
                    'page_header' => $rubric['page_header'],
                ];
            }

            foreach ($rootItem[Catalog::TREE_ITEM_CHILDREN] as $index => $rubric) {
                $rootItem[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processRubricDataLrparts($rubric, $otherRubrics);
            }

            return [$rootItem,];
        }, self::CACHE_DURATION_LRPARTS);
    }

    public static function _processRubricDataLrparts(array &$rubric, array &$otherRubrics) : array
    {
        foreach ($otherRubrics as $otherID => $other) {
            if ($rubric['id'] === $other['parent_id']) {
                unset($otherRubrics[$otherID]);

//                $count = !empty($other['is_last']) ? ParserLrpartsItems::find()->where(['rubric_id' => $otherID,])->count() : 0;

                $rubric[Catalog::TREE_ITEM_CHILDREN][] = [
                    'id' => $otherID,
                    'parent_id' => $other['parent_id'],
                    'name' => $other['name'],//.(!empty($other['is_last']) ? ' ['.$count.']' : ''),
                    'url' => '/'.MenuHelper::FIRST_MENU_PARSING.'/'.MenuHelper::SECOND_MENU_PARSING_LRPARTS.'/view?id='.$otherID,
                    'type' => self::TYPE_RUBRIC,
                    'font' => empty($other['is_active']) ? new JsExpression('{"color":"#8f8b8b", "font-style":"italic"}') : '',
                    'is_last' => $other['is_last'],
                    'title' => $other['title'],
                    'page_header' => $other['page_header'],
                ];
            }
        }

        if (!empty($rubric[Catalog::TREE_ITEM_CHILDREN])) {
            foreach ($rubric[Catalog::TREE_ITEM_CHILDREN] as $index => $other) {
                $rubric[Catalog::TREE_ITEM_CHILDREN][$index] = self::_processRubricDataLrparts($other, $otherRubrics);
            }
        }

        return $rubric;
    }

    /**
     * @return array
     */
    public static function getLrpartsRubricsData() : array
    {
        $cache = \Yii::$app->cache;
        $key = self::CACHE_KEY_LRPARTS_RUBRICS;
        //        $cache->delete($key);

        return $cache->getOrSet($key, function () {
            $rubrics = ParserLrpartsRubrics::find()->orderBy(['parent_id' => SORT_ASC, 'sort_field' => SORT_ASC,])->indexBy('id')->asArray()->all();

            return $rubrics;
        }, self::CACHE_DURATION_LRPARTS);
    }

    /**
     * @param int  $id
     * @param bool $isBackend
     *
     * @return string
     */
    public static function getLrPartsImageUrl(int $id, bool $isBackend = false) : string
    {
        $basePath = ($isBackend ? \Yii::getAlias('@backendImages') : \Yii::getAlias('@frontendImages')).DIRECTORY_SEPARATOR;
        $path = $basePath.'Parsing'.DIRECTORY_SEPARATOR.'lrparts.ru'.DIRECTORY_SEPARATOR.$id;

        $pathes = [
            CatalogHelper::EXTENSION_JPG => $path.'.'.CatalogHelper::EXTENSION_JPG,
            CatalogHelper::EXTENSION_PNG => $path.'.'.CatalogHelper::EXTENSION_PNG,
        ];
        foreach ($pathes as $ext => $path) {
            if (file_exists($path)) {
                return self::IMAGES_PATH_LRPARTS.$id.'.'.$ext;
            }
        }

        return self::getLrPartsDefaultImageUrl();
    }

    /**
     * @return string
     */
    public static function getLrPartsDefaultImageUrl() : string
    {
        return '/img/'.Catalog::IMAGE_NOT_AVAILABLE;
    }

    /**
     * @param string $url
     *
     * @return array
     */
    public static function getLrPartsImageInfo(string $url) : array
    {
        $width = $height = 0;
        $basePath = \Yii::getAlias('@backendImages').DIRECTORY_SEPARATOR;
        $path = $basePath.'Parsing'.DIRECTORY_SEPARATOR.'lrparts.ru'.DIRECTORY_SEPARATOR.basename($basePath.$url);

        if (file_exists($path)) {
            [$width, $height, $type, $attr] = getimagesize($path);
        }

        return ['width' => $width, 'height' => $height, 'name' => basename($url),];
    }

    /**
     * @param string $content
     * @param string $word
     * @param string $backgroundColor
     * @param string $color
     *
     * @return string
     */
    public static function highlightWord(string $content, string $word, string $backgroundColor, string $color = '#fff') : string
    {
        $replace = '<span style="background-color: ' . $backgroundColor . '; color: ' . $color . ';">' . $word . '</span>';
        $content = str_replace( $word, $replace, $content );

        return $content;
    }

    /**
     * @param int  $rubricID
     * @param bool $isMainLabel
     *
     * @return array
     */
    public static function getLrpartsRubricBreadcrumbs(int $rubricID, bool $isMainLabel = true) : array
    {
        $breadcrumbs = [];
        $rubrics = self::getLrpartsRubricsData();

        while (true) {
            if (isset($rubrics[$rubricID])) {
                $rubric = $rubrics[$rubricID];
                $breadcrumbs[] = ['label' => $rubric['name'], 'url' => ['lr-parts/view', 'id' => $rubric['id'],],];

                if (!empty($rubrics[$rubricID]['parent_id'])) {
                    $rubricID = $rubrics[$rubricID]['parent_id'];
                } else {
                    break;
                }
            } else {
                break;
            }
        }

        if ($isMainLabel) {
            $breadcrumbs[] = ['label' => \frontend\controllers\LrPartsController::BREADCRUMB_NAME, 'url' => ['/',],];
        }

        return array_reverse($breadcrumbs);
    }

    /**
     * @return int
     * @throws \yii\db\Exception
     */
    public static function setEpcInArticles() : int
    {
        set_time_limit(0);
        $items = [];

        $query = (new Query())->from(ParserLrpartsItems::tableName())->select(['id', 'code',]);
        foreach ($query->batch(1000) as $rows) {
            foreach ($rows as $row) {
                $items[strtolower($row['code'])] = $row['id'];
            }
        }

        ConsoleHelper::debug('$items count = '.count($items));

        $articles = Articles::find()->asArray()->select(['id', 'number', 'is_in_epc',])->all();

        ConsoleHelper::debug('$articles count = '.count($articles));

        $index = $updated = 0;
        foreach ($articles as $article) {
            if (isset($items[strtolower($article['number'])])) {
                if (empty($article['is_in_epc'])) {
                    $i = (new Query())->createCommand()->update(Articles::tableName(), ['is_in_epc' => true,], ['id' => $article['id'],])->execute();
                    $updated += $i;
                }
            } else {
                if (!empty($article['is_in_epc'])) {
                    $i = (new Query())->createCommand()->update(Articles::tableName(), ['is_in_epc' => false,], ['id' => $article['id'],])->execute();
                    $updated += $i;
                }
            }

            $index++;
            if ($index % 10000 === 0) {
                ConsoleHelper::debug('Пройдено '.$index);
            }
        }

        return $updated;
    }
}