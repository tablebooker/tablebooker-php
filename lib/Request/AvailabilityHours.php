<?php

namespace Tablebooker\Request;

use Tablebooker\Error;

class AvailabilityHours implements RequestResource
{
    protected $restaurantId;    // string, required
    protected $guests;          // int, required
    protected $day;             // string, required
    protected $couponId;        // string
    protected $promotionId;     // string
    protected $shiftId;         // string
    protected $duration;        // int
    protected $source;          // string
    protected $partnerId;       // string
    protected $reservationId;   // string

    /**
     * Creates a new AvailabilityHours Request entity.
     * @param string $restaurantId
     * @param int $guests
     * @param string $day
     * @param string|null $source
     * @param string|null $couponId
     * @param string|null $promotionId
     * @param string|null $shiftId
     * @param int|null $duration
     * @param string|null $partnerId
     * @param string|null $reservationId
     */
    public function __construct(
        $restaurantId,
        $guests,
        $day,
        $source = null,
        $couponId = null,
        $promotionId = null,
        $shiftId = null,
        $duration = null,
        $partnerId = null,
        $reservationId = null
    ) {
        $this->restaurantId = $restaurantId;
        $this->guests = $guests;
        $this->day = $day;
        $this->source = $source;
        $this->couponId = !empty($couponId) ? $couponId : null;
        $this->promotionId = !empty($promotionId) ? $promotionId : null;
        $this->shiftId = !empty($shiftId) ? $shiftId : null;
        $this->duration = $duration;
        $this->partnerId = $partnerId;
        $this->reservationId = $reservationId;
    }

    /**
     * @return bool
     * @throws Error\InvalidRequest
     */
    public function validate()
    {
        $invalidFields = array();
        if (!isset($this->restaurantId)) {
            $invalidFields['restaurantId'] = $this->restaurantId;
        }
        if (!isset($this->guests) || !is_numeric($this->guests)) {
            $invalidFields['guests'] = $this->guests;
        }
        if (!isset($this->day)) {
            $invalidFields['day'] = $this->day;
        }

        //TODO add more

        if (!empty($invalidFields)) {
            $message = 'Invalid data in AvailabilityHours request object: '.json_encode($invalidFields).'.';
            throw new Error\InvalidRequest($message);
        }

        return true;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = array(
            'restaurant_id' => $this->restaurantId,
            'guests' => $this->guests,
            'day' => $this->day,
            'coupon_id' => $this->couponId,
            'promotion_id' => $this->promotionId,
            'shift_id' => $this->shiftId,
            'duration' => $this->duration,
            'source' => $this->source,
            'partner_id' => $this->partnerId,
            'reservation_id' => $this->reservationId
        );

        $params = array_filter(
            $params,
            function ($val) {
                return isset($val);
            }
        );

        return $params;
    }
}