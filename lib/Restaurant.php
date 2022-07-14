<?php

namespace Tablebooker;

/**
 * Class Restaurant
 *
 * @package Tablebooker
 */
class Restaurant extends ApiResource
{
    public static function retrieve($id, $options = null) {
        $url = static::classUrl();
        $url .= "/info/" . $id;
        $params = array();

        $opts = Http\RequestOptions::parse($options);
        $requestor = new ApiRequestor($opts->apiKey);
        $response = $requestor->request('get', $url, $params, $opts->headers, null);

        return $response;
    }

    public static function sendMessage(Request\RestaurantSendMessage $requestData, Auth\AuthBasic $auth, $options = null)
    {
        $url = self::classUrl() . '/message/' . $requestData->restaurantId;
        $options['basic_auth_user'] = $auth->getUsername();
        $options['basic_auth_password'] = $auth->getPassword();
        $response = self::_staticRequest('post', $url, $requestData, $options);
        return $response;
    }
}