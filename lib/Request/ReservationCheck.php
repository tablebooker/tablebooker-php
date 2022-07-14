<?php

namespace Tablebooker\Request;

use bar\baz\source_with_namespace;
use Tablebooker\Error;

class ReservationCheck implements RequestResource
{
    protected $restaurantId;    // string, required
    protected $guests;          // int, required
    protected $timeslot;        // int
    protected $deviceId;        // string
    protected $partnerId;       // int
    protected $couponId;        // string
    protected $promotionId;     // string
    protected $duration;        // int
    protected $roomId;          // string
    protected $tableId;         // string
    protected $reservationId;   // string
    protected $userId;          // string
    protected $source;          // string
    protected $overrideAvailability;    // string
    protected $overrideTableChoice;     // string
    protected $shouldLock;      // bool


    /**
     * Creates a new ReservationCheck Request entity.
     */
    public function __construct($restaurantId, $guests, $timeslot, $source=null, $deviceId=null, $partnerId=null, $couponId=null, $promotionId=null, $duration=null, $roomId=null, $tableId=null, $reservationId=null, $userId=null, $overrideAvailability=null, $overrideTableChoice=null, $shouldLock=true)
    {
        $this->restaurantId = $restaurantId;
        $this->guests = $guests;
        $this->timeslot = $timeslot;
        $this->source = $source;
        $this->deviceId = $deviceId;
        $this->partnerId = !empty($partnerId)?$partnerId:null;
        $this->couponId = !empty($couponId)?$couponId:null;
        $this->promotionId = !empty($promotionId)?$promotionId:null;
        $this->duration = $duration;
        $this->roomId = !empty($roomId)?$roomId:null;
        $this->tableId = !empty($tableId)?$tableId:null;
        $this->reservationId = !empty($reservationId)?$reservationId:null;
        $this->userId = !empty($userId)?$userId:null;
        $this->overrideAvailability = !empty($overrideAvailability)?$overrideAvailability:null;
        $this->overrideTableChoice = !empty($overrideTableChoice)?$overrideTableChoice:null;
        $this->shouldLock = $shouldLock;
    }

    public function validate(){
        $invalidFields = array();
        if (!isset($this->restaurantId)){
            $invalidFields['restaurantId'] = $this->restaurantId;
        }
        if (!isset($this->guests) || !is_numeric($this->guests)){
            $invalidFields['guests'] = $this->guests;
        }
        if (!isset($this->timeslot) || !is_numeric($this->timeslot)){
            $invalidFields['timeslot'] = $this->timeslot;
        }
        if (isset($this->partnerId) && !is_numeric($this->partnerId)){
            $invalidFields['partnerId'] = $this->partnerId;
        }
        if (isset($this->duration) && !is_numeric($this->duration)){
            $invalidFields['duration'] = $this->duration;
        }

        if (!empty($invalidFields)){
            $message = 'Invalid data in ReservationCheck request object: ' . json_encode($invalidFields) . '.';
            throw new Error\InvalidRequest($message);
            return false;
        }

        return true;
    }

    public function getParams()
    {
        $params = array(
            'restaurant_id' => $this->restaurantId,
            'guests' => $this->guests,
            'timeslot' => $this->timeslot,
            'device_id' => $this->deviceId,
            'partner_id' => $this->partnerId,
            'coupon_id' => $this->couponId,
            'promotion_id' => $this->promotionId,
            'duration' => $this->duration,
            'room' => $this->roomId,
            'table' => $this->tableId,
            'reservation_id' => $this->reservationId,
            'user_id' => $this->userId,
            'source' => $this->source,
            'overrideAvailability' => $this->overrideAvailability,
            'overrideTableChoice' => $this->overrideTableChoice,
            'shouldLock' => $this->shouldLock
        );

        $params = array_filter($params, function($val) {
            return isset($val);
        });

        return $params;
    }


}