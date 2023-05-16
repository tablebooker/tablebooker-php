<?php

namespace Tablebooker;

use Tablebooker\Request\RestaurantInfo;

/**
 * Class Restaurant
 *
 * @package Tablebooker
 */
class Restaurant extends ApiResource
{
    /**
     * Call the restaurant info api. Retrieves all restaurant settings.
     *
     * @param Request\RestaurantInfo|string $requestData    The obfuscated restaurant is as a String or a RequestInfo object containing all request data.
     * @param array|null $options    Array containing all necessary options needed for this request as key => value pairs
     * @return ApiResponse
     * @throws Error\ApiError
     * @throws Error\AuthenticationError
     * @throws Error\InvalidRequest
     */
    public static function retrieve($requestData, $options = null) {
        $url = static::classUrl() . "/info";

        if (gettype($requestData) === 'string'){
            $requestData = new RestaurantInfo($requestData);
        }

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