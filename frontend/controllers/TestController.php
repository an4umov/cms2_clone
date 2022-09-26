<?php
namespace frontend\controllers;

use common\components\helpers\AppHelper;
use common\components\helpers\BlockHelper;
use common\components\helpers\CartHelper;
use common\components\helpers\CatalogHelper;
use common\components\helpers\ContentHelper;
use common\components\helpers\DaDataHelper;
use common\components\helpers\FormHelper;
use common\components\helpers\ParserHelper;
use common\components\helpers\PlanFixHelper;
use common\models\Block;
use common\models\BlockField;
use common\models\CartSettings;
use common\models\Content;
use common\models\ContentBlock;
use common\models\ContentBlockField;
use common\models\Form;
use common\models\FormField;
use common\models\FullPrice;
use common\models\Material;
use common\models\Menu;
use common\models\PriceList;
use common\models\ReferenceValue;
use common\models\SettingsCheckoutBuyer;
use core\ContentFilter;
use frontend\components\widgets\ProductOffersWidget;
use frontend\models\search\SiteSearch;
use frontend\models\SendForm;
use frontend\models\SendQuestionForm;
use guayaquil\guayaquillib\data\GuayaquilRequestOEM;
use guayaquil\guayaquillib\objects\CatalogListObject;
use guayaquil\guayaquillib\objects\CatalogObject;
use guayaquil\guayaquillib\objects\VehicleObject;
use Manticoresearch\Query\BoolQuery;
use Manticoresearch\Query\Equals;
use Manticoresearch\Query\Match;
use Manticoresearch\Query\MatchPhrase;
use Manticoresearch\Query\MatchQuery;
use Manticoresearch\Query\QueryString;
use Manticoresearch\Query\Range;
use Manticoresearch\Search;
use Yii;
use yii\base\InvalidParamException;
use yii\base\Module;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;

/**
 * Test controller
 */
class TestController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex()
    {
        $data = CartHelper::getCartSettingTypeData(CartSettings::TYPE_CART);

        return $this->render('index', ['message' => $data,]);
    }

    public function actionList()
    {
        $index = 0;
        $array = ['active', 'sort', 'text', 'color', 'checkbox', 'digit', 'checkbox2', 'digit2', 'digit3',];

        echo '<textarea cols="100" rows="20">';

        while ($index < count($array)) {
            $items = array_slice($array, $index, 4);

            echo '<div class="row">'.PHP_EOL;
            foreach ($items as $item) {
                echo '<div class="col-lg-3 col-xl-3">'.$item.'</div>'.PHP_EOL;
            }
            echo '</div>'.PHP_EOL;

            $index += 4;
        }

        echo '</textarea>';
    }

    /**
     * @param $key
     *
     * @return PriceList
     * @throws NotFoundHttpException
     */
    private function _getProduct($key) : PriceList
    {
        if (($product = CatalogHelper::getPriceListModelByKey($key)) !== null) {
            return $product;
        }

        throw new NotFoundHttpException('Товар не найден');
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionData()
    {
        $message = $inn = $kpp = $name = $type = '';

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $inn = $post['inn'] ?? '' ;
            $kpp = $post['kpp'] ?? '' ;
            $name = $post['name'] ?? '' ;
            $type = $post['type'] ?? '' ;

            $dadata = new DaDataHelper("2038a28df749ecde8cda802ef51a8788f93dda58");
            $dadata->init();

            $fields = [];
            if ($inn) {
                $fields["query"] = $inn;
            }
            if ($kpp) {
                $fields["kpp"] = $kpp;
            }
            if ($type) {
                if ($type === 'legal') {
                    $fields["type"] = 'LEGAL';
                } elseif ($type === 'individual') {
                    $fields["type"] = 'INDIVIDUAL';
                }
            }

            $message = $dadata->suggest("party", $fields);

            $dadata->close();
        }

        return $this->render('data', ['message' => $message, 'inn' => $inn, 'kpp' => $kpp, 'name' => $name, 'type' => $type,]);
    }

    public function actionLaximo()
    {
        $errors = [];
        $catalogCode = 'HONDA2017';
        $request = new GuayaquilRequestOEM('', '', 'ru_RU');
        $request->setUserAuthorizationMethod('ru241341', '3uxHTz3UVn3y');

        $request->appendListCatalogs();

        $data = $request->query();

        if ($request->error) {
            $errors[] = $request->error;
        }

        /**
         * @var CatalogListObject $catalogList
         */
        $catalogList = array_shift($data);
        $allCatalogs = $catalogList->catalogs;

        ///////////////////////////////////////////////////////////

        $request = new GuayaquilRequestOEM($catalogCode, '', 'ru_RU');
        $request->setUserAuthorizationMethod('ru241341', '3uxHTz3UVn3y');

        $request->appendGetCatalogInfo();

        $data = $request->query();

        if ($request->error) {
            $errors[] = $request->error;
        }

        /**
         * @var CatalogObject $catalogInfo
         */
        $catalogInfo = array_shift($data);

        ///////////////////////////////////////////////////////////


        $vin = 'JHMCL96806C216721';
        $request = new GuayaquilRequestOEM($catalogCode, '', 'ru_RU');
        $request->setUserAuthorizationMethod('ru241341', '3uxHTz3UVn3y');
        $request->appendFindVehicle($vin);
        $data = $request->query();

        $quickGroupsTree = $categoriesTree =  [];
        if (!empty($data)) {
            $allFoundedVehicles = array_shift($data);

            if (!empty($allFoundedVehicles) && !empty($allFoundedVehicles->vehicles)) {
                /**
                 * @var VehicleObject $firstVehicleForExample
                 */
                $firstVehicleForExample = array_shift($allFoundedVehicles->vehicles);

                $request = new GuayaquilRequestOEM($firstVehicleForExample->catalog, $firstVehicleForExample->ssd, 'ru_RU');
                $request->setUserAuthorizationMethod('ru241341', '3uxHTz3UVn3y');

                $request->appendListQuickGroup($firstVehicleForExample->vehicleid);
                $request->appendListCategories($firstVehicleForExample->vehicleid, -1, $firstVehicleForExample->ssd);

                $data = $request->query();

                if ($request->error) {
                    $errors[] = $request->error;
                }

                $quickGroupsTree = $data[0];
                $categoriesTree  = $data[1];
            }
        }

        return $this->render('laximo', [
            'allCatalogs' => $allCatalogs,
            'catalogInfo' => $catalogInfo,
            'quickGroupsTree' => $quickGroupsTree,
            'categoriesTree' => $categoriesTree,
            'errors' => $errors,
            'catalogCode' => $catalogCode,
            'vin' => $vin,
        ]);
    }

    public function actionMod()
    {
        $this->layout = false;
        $data = sha1('sdfsdfsdfds');

        return $this->render('mod', [
            'data' => $data,
        ]);
    }

    public function actionError500()
    {
        $a = 5 / 0;

        return $this->render('mod', [
            'data' => $data,
        ]);
    }

    public function actionParser()
    {
        $this->layout = false;

        $str = 'Код:DA-01720
В наличии:да
Артикул:ТТ-БМ-01
        602.55000
        RUB

702,00руб.


 Количество: *';

//        preg_match('/^([a-zA-Z\_0-9\.-]+)\n/u', $str, $data);
        preg_match('/^Код:(.*)\n/ui', $str, $data);

        return $this->render('mod', [
            'data' => $data,
        ]);
    }

    public function actionPrice()
    {
        $this->layout = 'bootstrap';
        $result = null;
        $isPost = false;
        $errorMessage = '';
        $article = $title = $priceFrom = $priceTo = $countFrom = $countTo = null;
        $number = 15;

        if (Yii::$app->request->isPost) {
            $isPost = true;
            $post = Yii::$app->request->post();

            $article = !empty($post['article']) ? trim($post['article']) : '';
            $title = !empty($post['title']) ? trim($post['title']) : '';
            $priceFrom = !empty($post['price_from']) ? intval(trim($post['price_from'])) : 0;
            $priceTo = !empty($post['price_to']) ? intval(trim($post['price_to'])) : 0;
            $countFrom = !empty($post['count_from']) ? intval(trim($post['count_from'])) : 0;
            $countTo = !empty($post['count_to']) ? intval(trim($post['count_to'])) : 0;
            $number = !empty($post['number']) ? intval(trim($post['number'])) : 0;

            if (!empty($article) || !empty($title) || !empty($priceFrom) || !empty($priceTo) || !empty($countFrom) || !empty($countTo)) {
                $config = ['host' => '95.216.65.244', 'port' => 9311, 'retries' => 1,];
                $client = new \Manticoresearch\Client($config);

                $search = new Search($client);
                $search->setIndex('priceindex');
                $search->limit($number);

                $q = new BoolQuery();
                if (!empty($article)) {
                    $q->must(new QueryString($article));
                }
                if (!empty($title)) {
                    $q->must(new MatchQuery(['query' => $title, 'operator' => 'and'], 'name,description'));
                }
                if (!empty($priceFrom) || !empty($priceTo)) {
                    if (!empty($priceFrom) && empty($priceTo)) {
                        $args = ['gte' => $priceFrom,];
                    } elseif (empty($priceFrom) && !empty($priceTo)) {
                        $args = ['lte' => $priceTo,];
                    } else {
                        $args = ['gte' => $priceFrom, 'lte' => $priceTo,];
                    }

                    $q->must(new Range('price1', $args));
                }
                if (!empty($countFrom) || !empty($countTo)) {
                    if (!empty($countFrom) && empty($countTo)) {
                        $args = ['gte' => $countFrom,];
                    } elseif (empty($countFrom) && !empty($countTo)) {
                        $args = ['lte' => $countTo,];
                    } else {
                        $args = ['gte' => $countFrom, 'lte' => $countTo,];
                    }

                    $q->must(new Range('count', $args));
                }

                $result = $search->search($q)->get();
            } else {
                $errorMessage = 'Заполните одно из полей';
            }
        } else {

        }

        return $this->render('price', [
            'isPost' => $isPost,
            'article' => $article,
            'title' => $title,
            'priceFrom' => $priceFrom,
            'priceTo' => $priceTo,
            'countFrom' => $countFrom,
            'countTo' => $countTo,
            'number' => $number,
            'result' => $result,
            'errorMessage' => $errorMessage,
        ]);
    }

    public function actionPlanfix()
    {
        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials('numelion', 'cqWiz9AvHelO8DEX8RDf');
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $method = 'contact.getList';
        $params = [
            'pageCurrent' => 1,
            'pageSize' => 100,
        ];

        $contacts = $api->api($method, $params);

        if (empty($contacts['success'])) {
            if ($contacts['error_code'] === '0005') {
                $_SESSION[PlanFixHelper::SID] = null;
                unset($_SESSION[PlanFixHelper::SID]);
            }
        }

        return '<pre>'.print_r($contacts, 1).'</pre>';
    }

    public function actionPlanfixProjects()
    {
        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials('numelion', 'cqWiz9AvHelO8DEX8RDf');
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $method = 'project.getList';
        $params = [
            'pageCurrent' => 1,
            'pageSize' => 100,
        ];

        $contacts = $api->api($method, $params);

        if (empty($contacts['success'])) {
            if ($contacts['error_code'] === '0005') {
                $_SESSION[PlanFixHelper::SID] = null;
                unset($_SESSION[PlanFixHelper::SID]);
            }
        }

        return '<pre>'.print_r($contacts, 1).'</pre>';
    }

    public function actionPlanfixProjectGet()
    {
        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials('numelion', 'cqWiz9AvHelO8DEX8RDf');
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $method = 'project.get';
        $params = [
            'project' => [
                'id' => 121432,
            ],
        ];

        $project = $api->api($method, $params);

        if (empty($project['success'])) {
            if ($project['error_code'] === '0005') {
                $_SESSION[PlanFixHelper::SID] = null;
                unset($_SESSION[PlanFixHelper::SID]);
            }
        }

        return '<pre>'.print_r($project, 1).'</pre>';
    }

    public function actionPlanfixTasks()
    {
        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials('numelion', 'cqWiz9AvHelO8DEX8RDf');
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $method = 'task.getList';
        $params = [
            'pageCurrent' => 1,
            'pageSize' => 100,
        ];

        $contacts = $api->api($method, $params);

        if (empty($contacts['success'])) {
            if ($contacts['error_code'] === '0005') {
                $_SESSION[PlanFixHelper::SID] = null;
                unset($_SESSION[PlanFixHelper::SID]);
            }
        }

        return '<pre>'.print_r($contacts, 1).'</pre>';
    }

    public function actionPlanfixTaskGet()
    {
        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials('numelion', 'cqWiz9AvHelO8DEX8RDf');
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $method = 'task.get';
        $params = [
            'task' => [
                'general' => 20946,
            ],
        ];

        $task = $api->api($method, $params);

        if (empty($task['success'])) {
            if ($task['error_code'] === '0005') {
                $_SESSION[PlanFixHelper::SID] = null;
                unset($_SESSION[PlanFixHelper::SID]);
            }
        }

        return '<pre>'.print_r($task, 1).'</pre>';
    }

    public function actionPlanfix2()
    {
        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials('numelion', 'cqWiz9AvHelO8DEX8RDf');
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $method = 'contact.get';
        $params = [
            'contact' => [
                'general' => 322,
//                'general' => 6667,
            ],
        ];

        $contact = $api->api($method, $params);

        if (empty($contact['success'])) {
            if ($contact['error_code'] === '0005') {
                $_SESSION[PlanFixHelper::SID] = null;
                unset($_SESSION[PlanFixHelper::SID]);
            }
        }

        echo '<pre>'.print_r($contact, 1).'</pre>';

    }

    public function actionPlanfix3()
    {
        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials('numelion', 'cqWiz9AvHelO8DEX8RDf');
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $method = 'task.getList';
        $params = [
            'pageCurrent' => 1,
            'pageSize' => 100,
        ];

        $tasks = $api->api($method, $params);

        if (empty($tasks['success'])) {
            if ($tasks['error_code'] === '0005') {
                $_SESSION[PlanFixHelper::SID] = null;
                unset($_SESSION[PlanFixHelper::SID]);
            }
        }

        return '<pre>'.print_r($tasks, 1).'</pre>';
    }

    public function actionPlanfix4()
    {
        $api = new PlanFixHelper();

        if (empty($_SESSION[PlanFixHelper::SID])) {
            $api->setUserCredentials('numelion', 'cqWiz9AvHelO8DEX8RDf');
            $api->authenticate();
            $_SESSION[PlanFixHelper::SID] = $api->getSid();
        }

        $api->setSid($_SESSION[PlanFixHelper::SID]);

        $method = 'handbook.getList';
        $params = [

        ];

        $tasks = $api->api($method, $params);

        if (empty($tasks['success'])) {
            if ($tasks['error_code'] === '0005') {
                $_SESSION[PlanFixHelper::SID] = null;
                unset($_SESSION[PlanFixHelper::SID]);
            }
        }

        return '<pre>'.print_r($tasks, 1).'</pre>';
    }

}
