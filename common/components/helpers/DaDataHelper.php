<?php
namespace common\components\helpers;


use backend\components\helpers\IconHelper;
use common\models\Settings;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;

class DaDataHelper
{
    const TOKEN = '2038a28df749ecde8cda802ef51a8788f93dda58';
    const SECRET = '807123d4eda33fbc33713e4b4946586df9bd4366';
    const BASE_URL = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs';

    const SUGGESTION_COUNT = 10;

    private $_handle;
    private $_client;

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->_client;
    }

    public function curlInit()
    {
        $this->_handle = curl_init();
        curl_setopt($this->_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->_handle, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Token " . self::TOKEN,
            "X-Secret: " . self::SECRET,
        ));
        curl_setopt($this->_handle, CURLOPT_POST, 1);
    }

    public function init()
    {
        $this->_client = new \Dadata\DadataClient(self::TOKEN, self::SECRET);
    }

    public function findByAddress(string $address)
    {
        return $this->getClient()->clean('address', $address);
    }

    public function suggest(string $name)
    {
        return $this->getClient()->suggest('party', $name, self::SUGGESTION_COUNT);
    }

    public function findById(string $bik)
    {
        return $this->getClient()->findById('bank', $bik, 1);
    }







    /**
     * See https://dadata.ru/api/outward/ for details.
     */
//    public function findById($type, $fields) {
//        $url = self::BASE_URL . "/findById/$type";
//        return $this->executeRequest($url, $fields);
//    }

    /**
     * See https://dadata.ru/api/geolocate/ for details.
     */
    public function geolocate($lat, $lon, $count = 10, $radius_meters = 100)
    {
        $url = self::BASE_URL . "/geolocate/address";
        $fields = array(
            "lat" => $lat,
            "lon" => $lon,
            "count" => $count,
            "radius_meters" => $radius_meters
        );
        return $this->executeRequest($url, $fields);
    }

    /**
     * See https://dadata.ru/api/iplocate/ for details.
     */
    public function iplocate($ip)
    {
        $url = self::BASE_URL . "/iplocate/address?ip=" . $ip;
        return $this->executeRequest($url, $fields = null);
    }

    /**
     * See https://dadata.ru/api/suggest/ for details.
     */
//    public function suggest($type, $fields) {
//        $url = self::BASE_URL . "/suggest/$type";
//        return $this->executeRequest($url, $fields);
//    }

    public function close()
    {
        curl_close($this->_handle);
    }

    private function executeRequest($url, $fields)
    {
        curl_setopt($this->_handle, CURLOPT_URL, $url);
        if ($fields != null) {
            curl_setopt($this->_handle, CURLOPT_POST, 1);
            curl_setopt($this->_handle, CURLOPT_POSTFIELDS, json_encode($fields));
        } else {
            curl_setopt($this->_handle, CURLOPT_POST, 0);
        }
        $result = curl_exec($this->_handle);
        $result = json_decode($result, true);

        return $result;
    }
}