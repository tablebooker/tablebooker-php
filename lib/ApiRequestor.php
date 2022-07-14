<?php

namespace Tablebooker;

use GuzzleHttp;

/**
 * Class ApiRequestor
 *
 * @package Tablebooker
 */
class ApiRequestor
{
//    private $_CI;
    private $_apiKey;
    private $_apiBase;
    private $_verifySSL;

    /*
     * var GuzzleHttp\ClientInterface
     */
    private static $_httpClient;

    public function __construct($apiKey = null, $apiBase = null, $verifySSL = null)
    {
        if (!$apiKey) {
            $apiKey = Tablebooker::$apiKey;
        }
        if (!$apiBase) {
            $apiBase = Tablebooker::$apiBase;
        }
        if (is_null($verifySSL)) {
            $verifySSL = Tablebooker::$verifySslCerts;
        }

        $this->_apiKey = $apiKey;
        $this->_apiBase = $apiBase;
        $this->_verifySSL = $verifySSL;
    }

    /**
     * @param string $method    the HTTP request method (get, post, put, delete)
     * @param string $url       the actual API url to call
     * @param array $params     the actual array with request data
     * @param array|null $headers
     * @param array|null $auth
     * @param boolean $rawResponse Allow raw response to be returned without validating json data
     *
     * @return ApiResponse the API response.
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an invalid response was returned by the API
     */
    public function request($method, $url, $params = null, $headers = null, $auth = null, $rawResponse = false)
    {
        if (!$params) {
            $params = array();
        }
        if (!$headers) {
            $headers = array();
        }
        list($rbody, $rcode, $rheaders) = $this->_requestRaw($method, $url, $params, $headers, $auth);
        if ($rawResponse) {
            $json = null;
        } else {
            $json = $this->_interpretResponse($rbody, $rcode, $rheaders);
        }
        $response = new ApiResponse($rbody, $rcode, $rheaders, $json);

        return $response;
    }

    private static function _defaultHeaders($apiKey)
    {
        $defaultHeaders = array(
            'X-API-KEY' => $apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Accept-Language' => Tablebooker::$lang
        );

        return $defaultHeaders;
    }

    private function _requestRaw($method, $url, $params, $headers, $auth)
    {
        if (!$this->_apiKey) {
            $msg = 'No API key provided. (HINT: set your API key using '
              . '"Tablebooker::setApiKey(<API-KEY>)".';
            throw new Error\AuthenticationError($msg);
        }

        $absUrl = $this->_apiBase . $url;
        $combinedHeaders = array_merge($this->_defaultHeaders($this->_apiKey), $headers);

        $options = array(
            'headers' => $combinedHeaders,
            // The headers to add to the request.
            'auth' => $auth,
            // HTTP authentication parameters to use with the request. Null disables authentication.
            'timeout' => 0,
            // Waits indefinitely (the default behavior).
            'connect_timeout' => 10,
            // Number of seconds to wait while trying to connect to a server.
            'verify' => $this->_verifySSL,
            // SSL certificate verification.
        );

        if ('GET' == strtoupper($method)) {
            $absUrl .= '?' . http_build_query($params);
        } else {
            $options['json'] = $params;
            // Indicates we're uploading JSON encoded data.
        }
        $request = new GuzzleHttp\Psr7\Request($method, $absUrl);

        try {
            $timer_start = microtime(true);
            $rawResponse = $this->httpClient()->send($request, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $resp = $e->getResponse();
                error_log("Tablebooker API Client Notice: Could not handle request. [".$resp->getStatusCode()."] [".$method."] " . $absUrl . " - " . $e->getMessage() . " | [REQUEST DATA]: " . json_encode($params) . " | [REQUEST HEADERS]: " . json_encode($combinedHeaders) . " | [REQUEST TIMING]: " . (microtime(true) - $timer_start) ." seconds.");
                throw new Error\ApiError(
                    $e->getMessage(),
                    $resp->getStatusCode(),
                    $resp->getBody()->getContents(),
                    $resp->getHeaders()
                );
            }

            error_log("Tablebooker API Client Notice: Could not handle request. [".$method."] " . $absUrl . " - " . $e->getMessage() . " | [REQUEST DATA]: " . json_encode($params) . " | [REQUEST HEADERS]: " . json_encode($combinedHeaders) . " | [REQUEST TIMING]: " . (microtime(true) - $timer_start) ." seconds.");
            throw new Error\ApiError($e->getMessage());
        }

        $rheaders = $rawResponse->getHeaders();
        $rbody = $rawResponse->getBody();
        $rcode = $rawResponse->getStatusCode();

        return array($rbody, $rcode, $rheaders);
    }

    private function _interpretResponse($rbody, $rcode, $rheaders)
    {
        $resp = json_decode($rbody, true);
        $jsonError = json_last_error();
        if ($resp === null && $jsonError !== JSON_ERROR_NONE) {
            $msg = "Invalid response body from API: $rbody "
                ."(HTTP response code was $rcode, json_last_error() was $jsonError)";
            throw new Error\ApiError($msg, $rcode, $rbody);
        }

        return $resp;
    }

    /**
     * @static
     *
     * @param GuzzleHttp\ClientInterface $client
     */
    public static function setHttpClient($client)
    {
        self::$_httpClient = $client;
    }

    /**
     * @return GuzzleHttp\Client
     */
    private function httpClient()
    {
        if (!self::$_httpClient) {
            self::$_httpClient = new GuzzleHttp\Client();
        }

        return self::$_httpClient;
    }
}