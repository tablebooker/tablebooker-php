<?php

namespace Tablebooker\Request;

use bar\baz\source_with_namespace;
use Tablebooker\Error;

class ReservationLock implements RequestResource
{

    protected $restaurantId;    // string, required
    protected $guests;          // int, required
    protected $timeslot;        // int, required
    protected $deviceId;        // string
    protected $duration;        // int
    protected $roomId;          // string
    protected $reservationId;   // string
    protected $source;          // string


    /**
     * Creates a new ReservationLock Request entity.
     */
    public function __construct($restaurantId, $guests, $timeslot, $deviceId, $duration=null, $roomId=null, $reservationId=null,$source=null)
    {
        $this->restaurantId = $restaurantId;
        $this->guests = $guests;
        $this->timeslot = $timeslot;
        $this->deviceId = $deviceId;
        $this->duration = $duration;
        $this->roomId = !empty($roomId)?$roomId:null;
        $this->reservationId = !empty($reservationId)?$reservationId:null;
        $this->source = $source;
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
        if (!isset($this->deviceId)){
            $invalidFields['deviceId'] = $this->deviceId;
        }
        if (isset($this->duration) && !is_numeric($this->duration)){
            $invalidFields['duration'] = $this->duration;
        }

        if (!empty($invalidFields)){
            $message = 'Invalid data in ReservationLock request object: ' . json_encode($invalidFields) . '.';
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
            'duration' => $this->duration,
            'room' => $this->roomId,
            'reservation_id' => $this->reservationId,
            'source' => $this->source,
        );

        $params = array_filter($params, function($val) {
            return isset($val);
        });

        return $params;
    }


}