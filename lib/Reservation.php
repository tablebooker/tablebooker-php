<?php

namespace Tablebooker;

/**
 * Class Reservation
 *
 * @package Tablebooker
 */
class Reservation extends ApiResource
{

    /**
     * Get all days where there is at least one spot available.

     * @param Request\AvailabilityDays $requestData the Request\RequestResource containing the request data
     * @param array|string|null $options Optional array of options.
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    public static function availableDays(Request\AvailabilityDays $requestData, $options = null)
    {
        $url = self::classUrl() . '/availabledays';
        $response = self::_staticRequest('get', $url, $requestData, $options);

        return $response;
    }

    /**
     * Get all hours where there is at least one spot available.

     * @param Request\AvailabilityHours $requestData the Request\RequestResource containing the request data
     * @param array|string|null $options Optional array of options.
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    public static function availableHours(Request\AvailabilityHours $requestData, $options = null)
    {
        $url = self::classUrl() . '/availablehours';
        $response = self::_staticRequest('get', $url, $requestData, $options);

        return $response;
    }

    /**
     * Create a new reservation.
     *
     * @param Request\ReservationCreate $requestData the Request\RequestResource containing the request data
     * @param Auth\AuthBasic $auth the required authentication data
     * @param array|string|null $options Optional array of options.
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    public static function create(Request\ReservationCreate $requestData, Auth\AuthBasic $auth, $options = null)
    {
        return self::_create($requestData, $auth, $options);
    }

    /**
     * Update a reservation.
     *
     * @param string $id The ID of the reservation to update.
     * @param Request\ReservationUpdate $requestData the Request\RequestResource containing the request data
     * @param Auth\AuthBasic $auth the required authentication data
     * @param array|string|null $options Optional array of options.
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    public static function update($id, Request\ReservationUpdate $requestData, Auth\AuthBasic $auth, $options = null)
    {
        return self::_update($id, $requestData, $auth, $options);
    }

    /**
     * Cancel a reservation.
     *
     * @param string $id The ID of the reservation to cancel.
     * @param Request\ReservationCancel $requestData the Request\RequestResource containing the request data
     * @param Auth\AuthBasic $auth the required authentication data
     * @param array|string|null $options Optional array of options.
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    public static function cancel($id, Request\ReservationCancel $requestData, Auth\AuthBasic $auth, $options = null)
    {
        return self::_delete($id, $requestData, $auth, $options);
    }

    /**
     * Check if a reservation is possible with the given ReservationCheck data. Creates a temporary reservation if
     * possible.
     *
     * @param Request\ReservationCheck $requestData the Request\RequestResource containing the request data
     * @param array|string|null $options Optional array of options.
     *
     * @return ApiResponse
     * @throws Error\InvalidRequest when requestData is not valid
     * @throws Error\AuthenticationError when no API key was provided
     * @throws Error\ApiError when an API related error occurred (invalid response, invalid or missing options, ...)
     */
    public static function check(Request\ReservationCheck $requestData, $options = null)
    {
        $url = self::classUrl() . '/checkReservation';
        $response = self::_staticRequest('get', $url, $requestData, $options);

        return $response;
    }

    public static function renewLock(Request\ReservationLock $requestData, $options = null)
    {
        $url = self::classUrl() . '/renewLock';
        $response = self::_staticRequest('get', $url, $requestData, $options);

        return $response;
    }
}