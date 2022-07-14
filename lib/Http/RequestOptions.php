<?php

namespace Tablebooker\Http;

use Tablebooker\Error;

class RequestOptions
{
    public $headers;
    public $auth;
    public $apiKey;

    public function __construct($key = null, $auth = array(), $headers = array())
    {
        $this->apiKey = $key;
        $this->auth = $auth;
        $this->headers = $headers;
    }

    /**
     * Unpacks an options array into a RequestOptions object
     * @param array|string|null $options a key => value array
     *
     * @return RequestOptions
     * @throws Error\ApiError when an invalid options argument is provided.
     */
    public static function parse($options)
    {
        if ($options instanceof self) {
            return $options;
        }

        if (is_null($options)) {
            return new RequestOptions(null, array(), array());
        }

        if (is_string($options)) {
            return new RequestOptions($options, array(), array());
        }

        if (is_array($options)) {
            $auth = array();
            $headers = array();
            $auth = array();
            $key = null;
            if (array_key_exists('api_key', $options)) {
                $key = $options['api_key'];
            }
            if (array_key_exists('basic_auth_user', $options) && array_key_exists('basic_auth_password', $options)) {
                $auth = [$options['basic_auth_user'], $options['basic_auth_password']];
            }
            if (array_key_exists('language', $options)) {
                $headers['Accept-Language'] = $options['language'];
            }
            return new RequestOptions($key, $auth, $headers);
        }

        $message = 'The options argument to Tablebooker API method calls is an '
            . 'optional per-request apiKey, which must be a string, or '
            . 'per-request basic auth credentials, which must be an array, or '
            . 'per-request options, which must be an array.';
        throw new Error\ApiError($message);
    }
}