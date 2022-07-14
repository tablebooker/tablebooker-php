<?php

namespace Tablebooker;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class RestaurantTest extends TestCase
{
    public function testRetrieve()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/restaurant_retrieve.json')));

        $response = Restaurant::retrieve("0003487");
        $this->assertEquals(200, $response->code);
        $this->assertEquals("L'Exemple", $response->json['name']);
        $this->assertEquals("0003487", $response->json['tablebooker_id']);
    }

    public function testRetrieveUnknown()
    {
        $this->mockHandler->append(new Response(404, [], ' { "status": "error", "error_code": "unknown_restaurant", "error": "Unknown restaurant." }'));

        $response = Restaurant::retrieve("1234567");
        $this->assertEquals(404, $response->code);
        $this->assertEquals("unknown_restaurant", $response->json['error_code']);
    }

    public function testSendMessage()
    {
        $this->mockHandler->append(new Response(200, [], '{ "message_id": 12345678 }'));

        $requestData = new Request\RestaurantSendMessage(
            "0003487",
            "PHPUnit",
            "phpunit@tablebooker.com",
            "Unit test message",
            "This is a test message"
        );

        $response = Restaurant::sendMessage($requestData, $this->basicAuth);
        $this->assertEquals(200, $response->code);
        $this->assertEquals(12345678, $response->json['message_id']);
    }

    /**
     * @expectedException \Tablebooker\Error\ApiError
     * @expectedExceptionMessage Invalid response body from API: { "status" => "error", "error_code" => "invalid_field", "error_explanation" => "Sender missing" }
     */
    public function testSendMessageUnknownSender()
    {
        $this->mockHandler->append(new Response(400, [], '{ "status" => "error", "error_code" => "invalid_field", "error_explanation" => "Sender missing" }'));

        $requestData = new Request\RestaurantSendMessage(
            "0003487",
            "PHPUnit",
            null,
            "Unit test message",
            "This is a test message"
        );

        Restaurant::sendMessage($requestData, $this->basicAuth);
    }
}
