<?php

namespace Tablebooker;

use Tablebooker\Auth\AuthBasic;
use Tablebooker\Error\InvalidRequest;
use Tablebooker\Request\RequestResource;

/**
 * Class ApiResource
 *
 * @package Tablebooker
 */
abstract class ApiResource
{
    /**
     * @return string The name of the class in lowercase, with namespacing and underscores stripped.
     */
    public static function className()
    {
        $class = get_called_class();
        // Useful for namespaces: Foo\Tablebooker
        if ($postfixNamespaces = strrchr($class, '\\')) {
            $class = substr($postfixNamespaces, 1);
        }
        // Useful for underscored 'namespaces': Foo_Tablebooker
        if ($postfixFakeNamespaces = strrchr($class, '')) {
            $class = $postfixFakeNamespaces;
        }
        if (substr($class, 0, strlen('Tablebooker')) == 'Tablebooker') {
            $class = substr($class, strlen('Tablebooker'));
        }
        $class = str_replace('_', '', $class);
        $name = urlencode($class);
        $name = strtolower($name);

        return $name;
    }

    /**
     * @return string The endpoint URL for the given class.
     */
    public static function classUrl()
    {
        $base = static::className();
        return "/v2/${base}s";
    }

    /**
     * @param string $id The id of the instance.
     *
     * @return string The instance endpoint URL for the given class.
     * @throws InvalidRequest error when invalid id was provided.
     */
    public static function resourceUrl($id)
    {
        if ($id === null) {
            $class = get_called_class();
            $message = "Could not determine which URL to request: " . $class . " instance has invalid ID: " . $id;
            throw new Error\InvalidRequest($message);
        }
        $base = static::classUrl();
        return $base . '/' . urlencode($id);
    }

    /**
     * @param string $method    the HTTP request method (get, post, put, delete)
     * @param string $url       the actual API url to call
     * @param Request\RequestResource $requestData  the Request\RequestResource containing the request data
     * @param array $options    array containing all necessary options needed for this request as key => value pairs
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    protected static function _staticRequest($method, $url, Request\RequestResource $requestData, $options)
    {
        $params = array();
        if ($requestData && $requestData->validate()) {
            $params = $requestData->getParams();
        }

        $opts = Http\RequestOptions::parse($options);
        $requestor = new ApiRequestor($opts->apiKey);
        $response = $requestor->request($method, $url, $params, $opts->headers, $opts->auth);

        return $response;
    }

    /**
     * @param RequestResource|null $requestData  the Request\RequestResource containing the request data
     * @param Auth\AuthBasic $auth the required authentication data
     * @param array $options array containing all necessary options needed for this request as key => value pairs
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    protected static function _create(Request\RequestResource $requestData = null, Auth\AuthBasic $auth, $options)
    {
        $url = static::classUrl();
        $options['basic_auth_user'] = $auth->getUsername();
        $options['basic_auth_password'] = $auth->getPassword();
        $response = static::_staticRequest('post', $url, $requestData, $options);
        return $response;
    }

    /**
     * @param string $id The ID of the API resource to update.
     * @param RequestResource|null $requestData  the Request\RequestResource containing the request data
     * @param Auth\AuthBasic $auth the required authentication data
     * @param array $options array containing all necessary options needed for this request as key => value pairs
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    protected static function _update($id, Request\RequestResource $requestData = null, Auth\AuthBasic $auth, $options)
    {
        $url = static::resourceUrl($id);
        $options['basic_auth_user'] = $auth->getUsername();
        $options['basic_auth_password'] = $auth->getPassword();
        $response = static::_staticRequest('put', $url, $requestData, $options);
        return $response;
    }

    /**
     * @param string $id The ID of the API resource to cancel/delete.
     * @param RequestResource|null $requestData  the Request\RequestResource containing the request data
     * @param Auth\AuthBasic $auth the required authentication data
     * @param array $options array containing all necessary options needed for this request as key => value pairs
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    protected static function _delete($id, Request\RequestResource $requestData = null, Auth\AuthBasic $auth, $options)
    {
        $url = static::resourceUrl($id);
        $options['basic_auth_user'] = $auth->getUsername();
        $options['basic_auth_password'] = $auth->getPassword();
        $response = static::_staticRequest('delete', $url, $requestData, $options);
        return $response;
    }
}