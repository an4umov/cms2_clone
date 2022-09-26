<?php

namespace frontend\rules;

use common\models\Material;
use common\models\Menu;
use services\UrlService;
use yii\base\InvalidConfigException;
use yii\helpers\VarDumper;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

class AliasUrlRule implements UrlRuleInterface
{
    private $urlService;

    const TYPE_MATERIAL = 'material';
    const TYPE_NODE = 'node';
    /**
     * Parses the given request and returns the corresponding route and parameters.
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|bool the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
        try {
            $pathInfo = $request->getPathInfo();
        } catch (InvalidConfigException $e) {
            return false;
        }
        if (empty($pathInfo) || $pathInfo === '/') {
            return false;
        }
        // для парсинга одинарных!!! урлов
        if ( preg_match('%[\w_\/-]+%', $pathInfo, $matches) ) {
            $this->urlService = new UrlService();
            return $this->urlService->parse($matches);
        }
        return false;
    }

    /**
     * Creates a URL according to the given route and parameters.
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|bool the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        if ( isset($params['alias']) ) {
            $this->urlService = new UrlService();
            return $this->urlService->create($params['alias']);
        }
        return false;
    }
}