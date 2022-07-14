<?php

namespace Tablebooker;

/**
 * Class General
 *
 * @package Tablebooker
 */
class General extends ApiResource
{
    public static function health($options = null) {
        $url = "/v2/health";
        $params = array();

        $opts = Http\RequestOptions::parse($options);
        $requestor = new ApiRequestor($opts->apiKey);
        $response = $requestor->request('get', $url, $params, $opts->headers, null, true);

        return $response;
    }
}