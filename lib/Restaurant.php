<?php

namespace Tablebooker;

/**
 * Class Restaurant
 *
 * @package Tablebooker
 */
class Restaurant extends ApiResource
{
    public static function retrieve(Request\RestaurantInfo $requestData, $options = null) {
        $url = static::classUrl() . "/info";
        return self::_staticRequest('get', $url, $requestData, $options);
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