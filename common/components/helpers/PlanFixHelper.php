<?php

namespace common\components\helpers;

use DOMDocument;
use \SimpleXMLElement;
use \Exception;

/**
 * Class PlanFixHelper
 *
 * @package common\components\helpers
 * @see     https://planfix.ru/docs/XML_API_v1
 */
class PlanFixHelper
{
    const ACCOUNT = 'lrru';
    const API_URL = 'https://apiru.planfix.ru/xml/';
    const API_KEY = 'a28de282f0a1e4d908fdc5a04b6c85b5';
    const API_SECRET = 'fadb32c3d936c5c8646a684bb962e26c';
    const SID = 'planfixSid';
    const LOGIN = 'numelion';
    const PASSWORD = 'cqWiz9AvHelO8DEX8RDf';

    const KEY_TOTAL_COUNT = 'totalCount';
    const KEY_COUNT = 'count';
    const KEY_SUCCESS = 'success';
    const KEY_ERROR_MSG = 'error_msg';
    const KEY_ERROR_CODE = 'error_code';
    const KEY_META = 'meta';
    const KEY_DATA = 'data';

    const PROJECT_STATUS_ACTIVE = 'ACTIVE';

    const HANDBOOK_CONTRACTOR_1C_ID = 8464; // Контрагенты 1С
    const HANDBOOK_CONTRACTOR_1C_TITLE = 'Контрагенты 1С'; // Контрагенты 1С
    const HANDBOOK_CONTRACTOR_1C_TABLE = '{{shop.handbook_contractor_1c}}'; // Контрагенты 1С

    const HANDBOOK_KEY = 'key';
    const HANDBOOK_ARCHIVED = 'archived';
    const HANDBOOK_CONTRACTOR_1C_CODE_ID = 24884;
    const HANDBOOK_CONTRACTOR_1C_CODE_NAME = 'code';
    const HANDBOOK_CONTRACTOR_1C_NAME_ID = 24886;
    const HANDBOOK_CONTRACTOR_1C_NAME_NAME = 'name';
    const HANDBOOK_CONTRACTOR_1C_NAME_OFFICIAL_ID = 24888;
    const HANDBOOK_CONTRACTOR_1C_NAME_OFFICIAL_NAME = 'name_official';
    const HANDBOOK_CONTRACTOR_1C_ADDRESS_ID = 24890;
    const HANDBOOK_CONTRACTOR_1C_ADDRESS_NAME = 'address';
    const HANDBOOK_CONTRACTOR_1C_BUYER_ID = 24892;
    const HANDBOOK_CONTRACTOR_1C_BUYER_NAME = 'buyer';
    const HANDBOOK_CONTRACTOR_1C_SUPPLIER_ID = 24894;
    const HANDBOOK_CONTRACTOR_1C_SUPPLIER_NAME = 'supplier';
    const HANDBOOK_CONTRACTOR_1C_TYPE_ID = 24896;
    const HANDBOOK_CONTRACTOR_1C_TYPE_NAME = 'type';

    const HANDBOOK_CONTRACTOR_1C_FIELDS = [
        self::HANDBOOK_CONTRACTOR_1C_CODE_ID => self::HANDBOOK_CONTRACTOR_1C_CODE_NAME,
        self::HANDBOOK_CONTRACTOR_1C_NAME_ID => self::HANDBOOK_CONTRACTOR_1C_NAME_NAME,
        self::HANDBOOK_CONTRACTOR_1C_NAME_OFFICIAL_ID => self::HANDBOOK_CONTRACTOR_1C_NAME_OFFICIAL_NAME,
        self::HANDBOOK_CONTRACTOR_1C_ADDRESS_ID => self::HANDBOOK_CONTRACTOR_1C_ADDRESS_NAME,
        self::HANDBOOK_CONTRACTOR_1C_BUYER_ID => self::HANDBOOK_CONTRACTOR_1C_BUYER_NAME,
        self::HANDBOOK_CONTRACTOR_1C_SUPPLIER_ID => self::HANDBOOK_CONTRACTOR_1C_SUPPLIER_NAME,
        self::HANDBOOK_CONTRACTOR_1C_TYPE_ID => self::HANDBOOK_CONTRACTOR_1C_TYPE_NAME,
    ];


    /**
     * Maximum size of a page for *.getList requests
     */
    const MAX_PAGE_SIZE = 100;

    /**
     * Default Curl options
     */
    public static $CURL_OPTS = [
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0,

        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_POSTREDIR => 1,
    ];

    /**
     * Maximum simultaneous Curl handles in a Multi Curl session
     */
    public static $MAX_BATCH_SIZE = 10;

    /**
     * Api url
     *
     * @var string
     */
    protected $apiUrl;

    /**
     * Api key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Api secret
     *
     * @var string
     */
    protected $apiSecret;

    /**
     * Account name (*.planfix.ru)
     *
     * @var string
     */
    protected $account;

    /**
     * User login
     *
     * @var string
     */
    protected $userLogin;

    /**
     * User password
     *
     * @var string
     */
    protected $userPassword;

    /**
     * Session identifier
     *
     * @var string
     */
    protected $sid;

    /**
     * Initializes a Planfix Client
     */
    public function __construct()
    {
        $this->setApiUrl(self::API_URL);
        $this->setApiKey(self::API_KEY);
        $this->setApiSecret(self::API_SECRET);
        $this->setAccount(self::ACCOUNT);
    }

    /**
     * Set the Api url
     *
     * @param string $apiUrl Api url
     *
     * @return PlanFixHelper
     */
    public function setApiUrl($apiUrl) : PlanFixHelper
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * Get the Api url
     *
     * @return string the Api url
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * Set the Api key
     *
     * @param string $apiKey Api key
     *
     * @return PlanFixHelper
     */
    public function setApiKey($apiKey) : PlanFixHelper
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get the Api key
     *
     * @return string the Api key
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set the Api secret
     *
     * @param string $apiKey Api secret
     *
     * @return PlanFixHelper
     */
    public function setApiSecret($apiSecret) : PlanFixHelper
    {
        $this->apiSecret = $apiSecret;

        return $this;
    }

    /**
     * Get the Api secret
     *
     * @return string the Api secret
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * Set the Account
     *
     * @param string $account Account
     *
     * @return PlanFixHelper
     */
    public function setAccount($account) : PlanFixHelper
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get the Account
     *
     * @return string the Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param $login
     * @param $password
     */
    public function setUserCredentials($login, $password)
    {
        $this->setUserLogin($login);
        $this->setUserPassword($password);
    }

    /**
     * Set the User login
     *
     * @param string $userLogin User login
     *
     * @return PlanFixHelper
     */
    public function setUserLogin($userLogin)
    {
        $this->userLogin = $userLogin;

        return $this;
    }

    /**
     * Get the User login
     *
     * @return string the User login
     */
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    /**
     * Set the User password
     *
     * @param string $userPassword User password
     *
     * @return PlanFixHelper
     */
    public function setUserPassword($userPassword) : PlanFixHelper
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    /**
     * Get the User password
     * Private for no external use
     *
     * @return string the User password
     */
    private function getUserPassword()
    {
        return $this->userPassword;
    }

    /**
     * Set the Sid
     *
     * @param string $sid Sid
     *
     * @return PlanFixHelper
     */
    public function setSid($sid) : PlanFixHelper
    {
        $this->sid = $sid;

        return $this;
    }

    /**
     * Get the Sid
     *
     * @return string the Sid
     */
    public function getSid()
    {
        return $this->sid;
    }

    /**
     * Authenticate with previously set credentials
     *
     * @return PlanFixHelper
     * @throws PlanFixHelperException
     */
    public function authenticate(): PlanFixHelper
    {
        $userLogin = $this->getUserLogin();
        $userPassword = $this->getUserPassword();
        $account = $this->getAccount();

        if (empty($userLogin) || empty($userPassword)) {
            throw new PlanFixHelperException('User credentials are not set');
        }
        if (!$account) {
            throw new PlanFixHelperException('Account is not set');
        }

        $params = [];
        $params['@attributes'] = ['method' => 'auth.login',];
        $params['login'] = $userLogin;
        $params['password'] = $userPassword;
        $params['account'] = $account;

        $xml = Array2XMLHelper::createXML('request', $params);

        $response = $this->makeRequest2($xml);

        if (!$response['success']) {
            throw new PlanFixHelperException('Unable to authenticate: ' . $response['error_str']);
        }

        $this->setSid($response['data']['sid']);

        return $this;
    }

    /**
     * Perform Api request
     *
     * @param string|array $method Api method to be called or group of methods for batch request
     * @param array        $params (optional) Parameters for called Api method
     *
     * @return array the Api response
     * @throws PlanFixHelperException
     */
    public function api($method, $params = [])
    {
        if (!$method) {
            throw new PlanFixHelperException('No method specified');
        }

        $sid = $this->getSid();

        if (!$sid) {
            $this->authenticate();
            $sid = $this->getSid();
        }
        $account = $this->getAccount();
        if (!$account) {
            throw new PlanFixHelperException('Account is not set');
        }

        $params['@attributes'] = ['method' => $method,];
        $params['sid'] = $sid;
        $params['account'] = $account;

        $xml = Array2XMLHelper::createXML('request', $params);

        if ($method === 'handbook.updateRecord') {
//            echo $xml->saveXML();
//            exit;
        }

        return $this->makeRequest2($xml);

    }

    /**
     * Create XML request
     *
     * @return SimpleXMLElement the XML request
     * @throws PlanFixHelperException
     */
    protected function createXml()
    {
        $requestXml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><request></request>');

        $account = $this->getAccount();

        if (!$account) {
            throw new PlanFixHelperException('Account is not set');
        }

        $requestXml->account = $account;

        return $requestXml;
    }

    /**
     * @param SimpleXMLElement $requestXml
     * @param                  $params
     *
     * @return SimpleXMLElement
     */
    protected function importParams(SimpleXMLElement $requestXml, $params)
    {
        foreach ($params as $key => $val) {
            if (is_array($val)) {
                $requestXml->$key = new SimpleXMLElement("<$key/>");
                foreach ($val as $key2 => $val2) {
                    if (is_array($val2)) {
                        $this->importParams($requestXml->$key, $val2);
                    } else {
                        $requestXml->$key->addChild($key2, $val2);
                    }
                }
            } else {
                $requestXml->addChild($key, $val);
            }
        }

        return $requestXml;
    }

    /**
     * Sign XML request
     *
     * @param SimpleXMLElement The XML request
     *
     * @return string the Signature
     * @throws PlanFixHelperException
     */
    protected function signXml($requestXml)
    {
        return md5($this->normalizeXml($requestXml) . $this->getApiSecret());
    }

    /**
     * Normalize the XML request
     *
     * @param SimpleXMLElement $node The XML request
     *
     * @return string the Normalized string
     */
    protected function normalizeXml($node)
    {
        $node = (array)$node;
        ksort($node);

        $normStr = '';

        foreach ($node as $child) {
            if (is_array($child)) {
                $normStr .= implode('', array_map([$this, 'normalizeXml'], $child));
            } elseif (is_object($child)) {
                $normStr .= $this->normalizeXml($child);
            } else {
                $normStr .= (string)$child;
            }
        }

        return $normStr;
    }

    /**
     * Make the batch request to Api
     *
     * @param array $batch The array of XML requests
     *
     * @return array the array of Api responses
     */
    protected function makeBatchRequest($batch)
    {
        $mh = curl_multi_init();

        $batchCnt = count($batch);
        $max_size = $batchCnt < self::$MAX_BATCH_SIZE ? $batchCnt : self::$MAX_BATCH_SIZE;

        $batchResult = [];

        for ($i = 0; $i < $max_size; $i++) {
            $requestXml = array_shift($batch);
            $ch = $this->prepareCurlHandle($requestXml);
            $chKey = (string)$ch;
            $batchResult[$chKey] = [];
            curl_multi_add_handle($mh, $ch);
        }

        do {
            do {
                $mrc = curl_multi_exec($mh, $running);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            while ($request = curl_multi_info_read($mh)) {
                $ch = $request['handle'];
                $chKey = (string)$ch;
                $batchResult[$chKey] = $this->parseApiResponse(curl_multi_getcontent($ch), curl_error($ch));

                if (count($batch)) {
                    $requestXml = array_shift($batch);
                    $ch = $this->prepareCurlHandle($requestXml);
                    $chKey = (string)$ch;
                    $batchResult[$chKey] = [];
                    curl_multi_add_handle($mh, $ch);
                }

                curl_multi_remove_handle($mh, $ch);
                curl_close($ch);
            }

            if ($running) {
                curl_multi_select($mh);
            }
        } while ($running && $mrc == CURLM_OK);

        return array_values($batchResult);
    }

    /**
     * Make the request to Api
     *
     * @param SimpleXMLElement $requestXml The XML request
     *
     * @return array the Api response
     */
    protected function makeRequest($requestXml)
    {
        $ch = $this->prepareCurlHandle($requestXml);

        $response = curl_exec($ch);
        $error = curl_error($ch);

//        echo '<pre>'.print_r($response, 1).'</pre>';
//        exit;

        return $this->parseApiResponse($response, $error);
    }

    protected function makeRequest2(DomDocument $xml)
    {
        $ch = $this->prepareCurlHandle2($xml);

        $response = curl_exec($ch);
        $error = curl_error($ch);

//        echo '<pre>'.print_r($response, 1).'</pre>';
//        exit;

        return $this->parseApiResponse($response, $error);
    }

    /**
     * Prepare the Curl handle
     *
     * @param SimpleXMLElement $requestXml The XML request
     *
     * @return resource the Curl handle
     */
    protected function prepareCurlHandle($requestXml)
    {
        $ch = curl_init($this->getApiUrl());

        curl_setopt_array($ch, self::$CURL_OPTS);

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getApiKey() . ':' . $this->getApiSecret());

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXml->asXML());

        return $ch;
    }

    protected function prepareCurlHandle2(DomDocument $xml)
    {
        $ch = curl_init($this->getApiUrl());

        curl_setopt_array($ch, self::$CURL_OPTS);

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getApiKey() . ':' . $this->getApiSecret());

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml->saveXML());

        return $ch;
    }

    /**
     * Parse the Api response
     *
     * @link http://goo.gl/GWa1c List of Api error codes
     *
     * @param string $response The Api response
     * @param string $error    The Curl error if any
     *
     * @return array the Curl handle
     */
    protected function parseApiResponse($response, $error)
    {
        $result = [
            self::KEY_SUCCESS => 1,
            self::KEY_ERROR_MSG => '',
            self::KEY_ERROR_CODE => '',
            self::KEY_META => null,
            self::KEY_DATA => null,
        ];

        if ($error) {
            $result[self::KEY_SUCCESS] = 0;
            $result[self::KEY_ERROR_MSG] = $error;

            return $result;
        }

        try {
            $responseXml = new SimpleXMLElement($response);
        } catch (Exception $e) {
            $result[self::KEY_SUCCESS] = 0;
            $result[self::KEY_ERROR_MSG] = $e->getMessage();

            return $result;
        }

        if ($responseXml['status'] == 'error') {
            $result[self::KEY_SUCCESS] = 0;
            $result[self::KEY_ERROR_MSG] = 'Code: ' . $responseXml->code;
            $result[self::KEY_ERROR_CODE] = (string)$responseXml->code;

            return $result;
        }

        if (isset($responseXml->sid)) {
            $result[self::KEY_DATA]['sid'] = (string)$responseXml->sid;
        } else {
            $responseXml = $responseXml->children();

            foreach ($responseXml->attributes() as $key => $val) {
                $result[self::KEY_META][$key] = (int)$val;
            }

            if ($result[self::KEY_META] == null || $result[self::KEY_META][self::KEY_TOTAL_COUNT] || $result[self::KEY_META][self::KEY_COUNT]) {
//                echo $response.PHP_EOL;

                $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);

                $result[self::KEY_DATA] = json_decode($json,true);
//                $result[self::KEY_DATA] = $this->exportData($responseXml);
            }
        }

        return $result;
    }

    /**
     * Exports the Xml response to array
     *
     * @param SimpleXMLElement $responseXml The Api response
     *
     * @return array the Exported data
     */
    protected function exportData($responseXml)
    {
        $root = $responseXml->getName();
        $data[$root] = [];

//        $rootChildren = $responseXml->children();

        $names = [];
        foreach ($responseXml->children() as $child) {
            $names[] = $child->getName();
        }

        $is_duplicate = count(array_unique($names)) != count($names) ? true : false;

        foreach ($responseXml->children() as $child) {
            if ($child->count() > 1) {
//                $data[$root] = array_merge($data[$root], $is_duplicate ? [$child->getName() => $this->exportData($child),] : $this->exportData($child));
                $data[$root] = array_merge($data[$root], $is_duplicate ? [$this->exportData($child),] : $this->exportData($child));
//                $data[$root][][$child->getName()] = $is_duplicate ? [$this->exportData($child)] : $this->exportData($child);
            } else {
                $data[$root][$child->getName()] = (string)$child;
            }
        }






//        $grandchildren = $child->children();
//
//        if ($grandchildren->count() || count($grandchildren) > 1) {
//            if (count($child->children()) > 1) {
//                $data[$root] = array_merge($data[$root],
//                    $is_duplicate ? [$this->exportData($child)] : $this->exportData($child));
//            } else {
//                $data[$root][$child->getName()] = (string)$child;
//            }
//        }

        return $data;
    }
}