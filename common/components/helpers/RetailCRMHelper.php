<?php
namespace common\components\helpers;

use Dompdf\Dompdf;

/**
 * Class RetailCRMHelper
 *
 * @package common\components\helpers
 * @see https://help.retailcrm.ru/Developers/Index
 * @api https://help.retailcrm.ru/Developers/ApiVersion5
 */
class RetailCRMHelper
{
    const URL = 'https://demo.retailcrm.ru';
    const API_KEY = 'T9DMPvuNt7FQJMszHUdG8Fkt6xHsqngH';

    /**
     * @param string $number
     *
     * @return mixed
     */
    public static function getOrder(string $number) : array
    {
        $return = ['result' => null, 'message' => '',];
        $client = new \RetailCrm\ApiClient(
            self::URL,
            self::API_KEY,
            \RetailCrm\ApiClient::V5
        );

        $response = null;
        try {
            $response = $client->request->ordersGet($number);
        } catch (\RetailCrm\Exception\CurlException $e) {
            $return['message'] = 'Ошибка соединения: ' . $e->getMessage();

            return $return;
        }

        if ($response->isSuccessful()) {
            $return['result'] = $response->getOrder();
            // or $response['order']['totalSumm'];
            // or
            //    $order = $response->getOrder();
            //    $order['totalSumm'];
        } else {
            $return['message'] = sprintf(
                "Ошибка: [HTTP-код %s] %s",
                $response->getStatusCode(),
                $response->getErrorMsg()
            );

            // error details
            //if (isset($response['errors'])) {
            //    print_r($response['errors']);
            //}
        }

        return $return;
    }

    /**
     * @param array $order
     *
     * @api https://help.retailcrm.ru/Developers/ApiVersion5#post--api-v5-orders-create
     *
     * @return array
     */
    public static function createOrder(array $order)
    {
        $return = ['result' => null, 'message' => '',];
        $client = new \RetailCrm\ApiClient(
            self::URL,
            self::API_KEY,
            \RetailCrm\ApiClient::V4
        );

        $response = null;
        try {
            $response = $client->request->ordersCreate($order);
        } catch (\RetailCrm\Exception\CurlException $e) {
            $return['message'] = "Ошибка соединения: " . $e->getMessage();
        }

        if ($response->isSuccessful() && 201 === $response->getStatusCode()) {
            $return['result'] = $response->id;
            $return['message'] = 'Заказ #'.$response->id.' создан';
            // or $response['id'];
            // or $response->getId();
        } else {
            $return['message'] = sprintf(
                "Ошибка: [HTTP-код %s] %s",
                $response->getStatusCode(),
                $response->getErrorMsg()
            );

            // error details
            //if (isset($response['errors'])) {
            //    print_r($response['errors']);
            //}
        }

        return $return;
    }

    /**
     * @param array $filter
     * @param null  $page
     * @param null  $limit
     *
     * @api https://help.retailcrm.ru/Developers/ApiVersion5#get--api-v5-orders
     *
     * @return array
     */
    public static function getOrders(array $filter, $page = null, $limit = null)
    {
        $return = ['result' => null, 'message' => '',];
        $client = new \RetailCrm\ApiClient(
            self::URL,
            self::API_KEY,
            \RetailCrm\ApiClient::V4
        );

        $response = null;
        try {
            $response = $client->request->ordersList($filter, $page, $limit);
        } catch (\RetailCrm\Exception\CurlException $e) {
            $return['message'] = "Ошибка соединения: " . $e->getMessage();
        }

        if ($response->isSuccessful() && 200 === $response->getStatusCode()) {
            $return['result'] = $response['orders'];
            // or $response['id'];
            // or $response->getId();
        } else {
            $return['message'] = sprintf(
                "Ошибка: [HTTP-код %s] %s",
                $response->getStatusCode(),
                $response->getErrorMsg()
            );

            // error details
            //if (isset($response['errors'])) {
            //    print_r($response['errors']);
            //}
        }

        return $return;
    }

    /**
     * @param array $filter
     * @param null  $page
     * @param null  $limit
     *
     * @api https://help.retailcrm.ru/Developers/ApiVersion5#get--api-v5-customers
     *
     * @return array
     */
    public static function getCustomers(array $filter, $page = null, $limit = null)
    {
        $return = ['result' => null, 'message' => '',];
        $client = new \RetailCrm\ApiClient(
            self::URL,
            self::API_KEY,
            \RetailCrm\ApiClient::V3
        );

        $response = null;
        try {
            $response = $client->request->customersList($filter, $page, $limit);
        } catch (\RetailCrm\Exception\CurlException $e) {
            $return['message'] = "Ошибка соединения: " . $e->getMessage();
        }

        if ($response->isSuccessful() && 200 === $response->getStatusCode()) {
            $return['result'] = $response['customers'];
        } else {
            $return['message'] = sprintf(
                "Ошибка: [HTTP-код %s] %s",
                $response->getStatusCode(),
                $response->getErrorMsg()
            );
        }

        return $return;
    }
}