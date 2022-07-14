<?php

namespace Tablebooker;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;

/**
 * Base class for Tablebooker test cases.
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /** var MockHandler HTTP client mocker */
    protected $mockHandler;

    /** @var Auth\AuthBasic */
    protected $basicAuth;

    protected function setUp()
    {
        Tablebooker::setConfig('tbkr_test_123');

        $this->basicAuth = new Auth\AuthBasic('test','test');
        $this->mockHandler = new MockHandler();

        $httpClient = new Client([
            'handler' => $this->mockHandler,
        ]);
        ApiRequestor::setHttpClient($httpClient);
    }

}