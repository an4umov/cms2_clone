<?php
namespace common\components\helpers;

use common\models\Articles;
use common\models\CatRecomend;
use common\models\Cross;
use common\models\FullPrice;
use common\models\PriceList;
use common\models\ReclamaStatus;
use common\models\SpecialOffers;
use frontend\components\widgets\SpecialOfferWidget;
use PharIo\Manifest\Library;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use \yii\helpers\Json;
use common\models\Block;
use common\models\BlockCommon;
use common\models\BlockField;
use common\models\BlockFieldList;
use common\models\BlockFieldValuesList;
use common\models\BlockReady;
use common\models\BlockReadyField;
use common\models\BlockReadyFieldValuesList;
use common\models\Catalog;
use common\models\Content;
use common\models\ContentBlock;
use common\models\Department;
use common\models\Form;
use common\models\FormField;
use frontend\components\widgets\LastNewsWidget;
use frontend\components\widgets\NewsTapeWidget;
use yii\helpers\Html;
use yii\helpers\Url;

class DocumentHelper
{
    const DOCS_DIR = 'docs';
    const DOCS_NAVIGATION_FILE = 'navigation.csv';
    const DOCS_NAVIGATION_FILE_DELIMETER = ';';
    const DOCS_NAVIGATION_ARTICLES_DELIMETER = ',';

    /**
     * @param array $numbers
     *
     * @return array
     */
    public static function getDocuments(array $numbers) : array
    {
        $data = $nums = [];
        foreach ($numbers as $number) {
            $nums[$number] = $number;
        }
        unset($numbers);
        $fileName = Yii::getAlias('@frontendDocs').DIRECTORY_SEPARATOR.self::DOCS_NAVIGATION_FILE;

        if (file_exists($fileName) && ($handle = fopen($fileName, "r")) !== FALSE) {
            while (($csvData = fgetcsv($handle, 1000, self::DOCS_NAVIGATION_FILE_DELIMETER)) !== FALSE) {
                $docName = $csvData[0] ?? '';
                $docDescription = $csvData[1] ?? '';
                $docArticles = $csvData[2] ?? '';

                if (!empty($docName) && !empty($docArticles)) {
                    $list = explode(self::DOCS_NAVIGATION_ARTICLES_DELIMETER, $docArticles);
                    foreach ($list as $i => $item) {
                        $item = trim($item);

                        if (isset($nums[$item])) {
                            $data[$docName] = ['name' => $docName, 'url' => Yii::getAlias('@frontendDocsWeb').'/'.$docName, 'description' => iconv('Windows-1251', 'UTF-8', $docDescription),];
                        }
                    }
                }
            }
            fclose($handle);
        }


        return $data;
    }
}