<?php

namespace Tablebooker\Request;

use Tablebooker\Error;

class AvailabilityDays implements RequestResource
{
    protected $restaurantId;    // string, required
    protected $guests;          // int, required
    protected $fromDate;        // string, required
    protected $toDate;          // string
    protected $couponId;        // string
    protected $promotionId;     // string
    protected $preload;         // boolean
    protected $shiftId;         // string
    protected $fromTimeSlot;    // string
    protected $toTimeSlot;      // string
    protected $source;          // string
    protected $partnerId;       // string
    protected $reservationId;   // string


    /**
     * Creates a new AvailabilityDays Request entity.
     * @param string $restaurantId
     * @param int $guests
     * @param string $fromDate
     * @param string|null $toDate
     * @param string|null $couponId
     * @param string|null $promotionId
     * @param string|null $preload
     * @param string|null $shiftId
     * @param string|null $fromTimeSlot
     * @param string|null $toTimeSlot
     * @param string|null $source
     * @param string|null $partnerId
     * @param string|null $reservationId
     */
    public function __construct(
        $restaurantId,
        $guests,
        $fromDate,
        $toDate = null,
        $couponId = null,
        $promotionId = null,
        $preload = null,
        $shiftId = null,
        $fromTimeSlot = null,
        $toTimeSlot = null,
        $source = null,
        $partnerId = null,
        $reservationId = null
    ) {
        $this->restaurantId = $restaurantId;
        $this->guests = $guests;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->couponId = $couponId;
        $this->promotionId = !empty($promotionId) ? $promotionId : null;
        $this->preload = $preload;
        $this->shiftId = $shiftId;
        $this->fromTimeSlot = $fromTimeSlot;
        $this->toTimeSlot = $toTimeSlot;
        $this->source = $source;
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
        if (!isset($this->fromDate)) {
            $invalidFields['fromDate'] = $this->fromDate;
        }
        //TODO add more

        if (!empty($invalidFields)) {
            $message = 'Invalid data in AvailabilityDays request object: '.json_encode($invalidFields).'.';
            throw new Error\InvalidRequest($message);
        }

        return true;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        //TODO RAS does not support shift_id. We should convert that to fromTimeSlot and toTimeSlot
        $params = array(
            'restaurant_id' => $this->restaurantId,
            'guests' => $this->guests,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'coupon_id' => $this->couponId,
            'promotion_id' => $this->promotionId,
            'preload' => $this->preload,
            'shift_id' => $this->shiftId,
            'timeslot_from' => $this->fromTimeSlot,
            'timeslot_to' => $this->toTimeSlot,
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