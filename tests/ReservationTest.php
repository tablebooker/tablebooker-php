<?php

namespace Tablebooker;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class ReservationTest extends TestCase
{
    public function testAvailableDays()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_availabledays.json')));

        $requestData = new Request\AvailabilityDays(
            "0003487",
            2,
            date('Y-m-d'),
            date('Y-m-d', strtotime('+1 week'))
        );

        $response = Reservation::availableDays($requestData);
        $this->assertEquals(200, $response->code);
        $this::assertCount(3, $response->json['result']);
        $this::assertInternalType('array', $response->json['result']['availableDays']);
        $this::assertEquals(count($response->json['result']['availableDays']), $response->json['count']);
    }

    /**
     * @expectedException \Tablebooker\Error\InvalidRequest
     * @expectedExceptionMessage Invalid data in AvailabilityDays request object: {"guests":null,"fromDate":null}.
     */
    public function testAvailableDaysInvalid()
    {
        $requestData = new Request\AvailabilityDays(
            "0003487",
            null,
            null
        );

        Reservation::availableDays($requestData);
    }

    public function testAvailableHours()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_availablehours.json')));

        $requestData = new Request\AvailabilityHours(
            "0003487",
            2,
            date('Y-m-d')
        );

        $response = Reservation::availableHours($requestData);
        $this->assertEquals(200, $response->code);
        $this::assertCount(2, $response->json['result']);
        $this::assertInternalType('array', $response->json['result']['availableHours']);
        $this::assertEquals(count($response->json['result']['availableHours']), $response->json['count']);
    }

    /**
     * @expectedException \Tablebooker\Error\InvalidRequest
     * @expectedExceptionMessage Invalid data in AvailabilityHours request object: {"guests":null,"day":null}.
     */
    public function testAvailableHoursInvalid()
    {
        $requestData = new Request\AvailabilityHours(
            "0003487",
            null,
            null
        );

        Reservation::availableHours($requestData);
    }


    public function testCheck()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_check.json')));

        $requestData = new Request\ReservationCheck(
            "0003487",
            2,
            time()
        );

        $response = Reservation::check($requestData);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('success', $response->json['status']);
        $this::assertInternalType('array', $response->json['message']);
    }

    public function testCheckClosed()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_check_closed.json')));

        $requestData = new Request\ReservationCheck(
            "0003487",
            2,
            time()
        );

        $response = Reservation::check($requestData);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('no_reservation_possible', $response->json['status']);
        $this->assertEquals('restaurant_closed', $response->json['reason']);
    }

    /**
     * @expectedException \Tablebooker\Error\InvalidRequest
     * @expectedExceptionMessage Invalid data in ReservationCheck request object: {"guests":null,"timeslot":null}.
     */
    public function testCheckInvalid()
    {
        $requestData = new Request\ReservationCheck(
            "0003487",
            null,
            null
        );

        $response = Reservation::check($requestData);
    }

    public function testCreate()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_create.json')));

        $reservationCustomerData = new \Tablebooker\Request\ReservationCreateCustomer(
            null,
            null,
            "personal",
            null,
            null,
            "PHPUnit",
            "Test",
            "phpunit@tablebooker.com",
            null,
            "2000"
        );

        $requestData = new Request\ReservationCreate(
            "0003487",
            2,
            time(),
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $reservationCustomerData
        );

        $response = Reservation::create($requestData, $this->basicAuth);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('OK', $response->json['status']);
        $this->assertNotEmpty($response->json["reservation_id"]);
        $this->assertNotEmpty($response->json["reservation_status"]);
    }

    public function testCreateNoTableAvailable()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_create_notableavailable.json')));

        $reservationCustomerData = new \Tablebooker\Request\ReservationCreateCustomer(
            null,
            null,
            "personal",
            null,
            null,
            "PHPUnit",
            "Test",
            "phpunit@tablebooker.com",
            null,
            "2000"
        );

        $requestData = new Request\ReservationCreate(
            "0003487",
            2,
            time(),
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $reservationCustomerData
        );

        $response = Reservation::create($requestData, $this->basicAuth);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('error', $response->json['status']);
        $this->assertEquals("no_table_available", $response->json["error_code"]);
        $this->assertNotEmpty($response->json["error_explanation"]);
    }


    /**
     * @expectedException \Tablebooker\Error\InvalidRequest
     * @expectedExceptionMessage Invalid data in ReservationCreate request object: {"guests":null}.
     */
    public function testCreateInvalid()
    {
        $requestData = new Request\ReservationCreate(
            "0003487",
            null,
            time()
        );

        Reservation::create($requestData, $this->basicAuth);
    }

    public function testUpdate()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_update.json')));

        $requestData = new Request\ReservationUpdate(
            "12345678",
            "0003487",
            4
        );

        $response = Reservation::update("123456789", $requestData, $this->basicAuth);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('OK', $response->json['status']);
        $this->assertEquals("123456789", $response->json["reservation_id"]);
        $this->assertNotEmpty($response->json["reservation_status"]);
    }

    public function testUpdateNotPossible()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_update_notpossible.json')));

        $requestData = new Request\ReservationUpdate(
            "12345678",
            "0003487",
            120
        );

        $response = Reservation::update("123456789", $requestData, $this->basicAuth);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('error', $response->json['status']);
        $this->assertNotEmpty($response->json["error_code"]);
        $this->assertNotEmpty($response->json["error_explanation"]);
    }

    /**
     * @expectedException \Tablebooker\Error\InvalidRequest
     * @expectedExceptionMessage Invalid data in ReservationUpdate request object: {"reservationId":null,"restaurantId":null}.
     */
    public function testUpdateInvalid()
    {
        $requestData = new Request\ReservationUpdate(null, null);

        Reservation::update("123456789", $requestData, $this->basicAuth);
    }

    public function testCancel()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_cancel.json')));

        $requestData = new Request\ReservationCancel(
            "123456789",
            "0003487"
        );

        $response = Reservation::cancel("123456789", $requestData, $this->basicAuth);
        $this->assertEquals(200, $response->code);
        $this->assertEquals('OK', $response->json['status']);
        $this->assertEquals("123456789", $response->json["reservation_id"]);
        $this->assertEquals("cancelled", $response->json["reservation_status"]);
    }

    public function testCancelUnknown()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_cancel_unknown.json')));

        $requestData = new Request\ReservationCancel(
            "123456789",
            "0003487"
        );

        $response = Reservation::cancel("123456789", $requestData, $this->basicAuth);
        $this->assertEquals('error', $response->json['status']);
        $this->assertEquals("unknown_reservation", $response->json["error_code"]);
        $this->assertNotEmpty($response->json["error_explanation"]);
    }

    /**
     * @expectedException \Tablebooker\Error\InvalidRequest
     * @expectedExceptionMessage Invalid data in ReservationCancel request object: {"reservationId":"res123456789"}.
     */
    public function testCancelInvalid()
    {
        $requestData = new Request\ReservationCancel(
            "res123456789",
            "0003487"
        );

        Reservation::cancel("123456789", $requestData, $this->basicAuth);
    }

    public function testRenewLock()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_renewlock.json')));

        $requestData = new Request\ReservationLock(
            "0003487",
            2,
            time(),
            "ABCDEFG1234"
        );

        $response = Reservation::renewLock($requestData);
        $this->assertEquals('renewed', $response->json['status']);
    }

    public function testRenewLockUnknown()
    {
        $this->mockHandler->append(new Response(200, [], file_get_contents(__DIR__ . '/mocks/reservation_renewlock_unknown.json')));

        $requestData = new Request\ReservationLock(
            "0003487",
            2,
            time(),
            "ABCDEFG1234"
        );

        $response = Reservation::renewLock($requestData);
        $this->assertEquals('unknown', $response->json['status']);
    }

    /**
     * @expectedException \Tablebooker\Error\InvalidRequest
     * @expectedExceptionMessage Invalid data in ReservationLock request object: {"deviceId":null}.
     */
    public function testRenewLockInvalid()
    {
        $requestData = new Request\ReservationLock(
            "0003487",
            2,
            time(),
            null
        );

        Reservation::renewLock($requestData);

    }

}
