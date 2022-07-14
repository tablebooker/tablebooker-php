<?php

namespace Tablebooker;

/**
 * Class Tablebooker
 *
 * @package Tablebooker
 */
class Tablebooker
{
    // @var string The Tablebooker API key to be used for requests.
    public static $apiKey;

    // @var string The base URL for the Tablebooker API.
    public static $apiBase = 'https://api.tablebooker.com';

    // @var boolean Whether SSL certificates need to be verified. Defaults to true.
    public static $verifySslCerts = true;

    // @var string The expected language in which response data should be returned, if supported. Defaults to 'en'.
    public static $lang = 'en';


    /**
     * Set Tablebooker API settings, all at once.
     *
     * @param string $apiKey    The Tablebooker API key to be used for requests.
     * @param string $lang      The expected language in which response data should be returned, if supported.
     * @param string $apiBase   The base URL for the Tablebooker API.
     * @param bool $verifySsl   Whether SSL certificates need to be verified.
     */
    public static function setConfig($apiKey, $lang=null, $apiBase=null, $verifySsl=true){
        self::$apiKey = $apiKey;
        self::$lang = !empty($lang)?$lang:'en';
        self::$apiBase = !empty($apiBase)?$apiBase:'https://api.tablebooker.com';
        self::$verifySslCerts = $verifySsl;
    }

    /**
     * @return string The API key used for requests.
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string The API base url.
     */
    public static function getApiBase()
    {
        return self::$apiBase;
    }

    /**
     * Sets the API base url.
     *
     * @param string $apiBase
     */
    public static function setApiBase($apiBase)
    {
        self::$apiBase = $apiBase;
    }

    /**
     * @return boolean
     */
    public static function getVerifySslCerts()
    {
        return self::$verifySslCerts;
    }

    /**
     * @param boolean $verifySsl
     */
    public static function setVerifySslCerts($verifySsl)
    {
        self::$verifySslCerts = $verifySsl;
    }

    /**
     * @return string The expected response language.
     */
    public static function getLang()
    {
        return self::$lang;
    }

    /**
     * Sets the expected response language for requests.
     *
     * @param string $lang
     */
    public static function setLang($lang)
    {
        self::$lang = $lang;
    }
}
