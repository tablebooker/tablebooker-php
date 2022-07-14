<?php

namespace Tablebooker\Request;

use Tablebooker\Error;

class ReservationUpdate implements RequestResource
{
    protected $reservationId;
    protected $restaurantId;
    protected $guests;
    protected $timeslot;
    protected $endTimeslot;
    protected $duration;
    protected $room;
    protected $table;
    protected $status;
    protected $notes;
    protected $waiter;
    protected $externalReservationId;
    protected $additionalData;
    protected $spam;
    protected $remove;
    protected $overrideAvailability;
    protected $overrideTableChoice;
    protected $swappable;
    protected $deviceId;
    protected $source;
    protected $userId;
    protected $partnerId;
    protected $partnerSource;
    protected $locked;


    /**
     * Creates a new ReservationUpdate Request entity, used for update of a reservation.
     *
     * @param string    $reservationId                  Required. Obfuscated reservation id.
     * @param string    $restaurantId                   Required. Obfuscated restaurant id.
     * @param int       $guests                         Number of guests to make a reservation for.
     * @param int       $timeslot                       Date and time of the reservation. Unix timestamp.
     * @param int       $endTimeslot                    Date and time when the reservation ends. Unix timestamp.
     * @param int       $duration                       Duration of the reservation.
     * @param string    $room                           Obfuscated id of the desired room.
     * @param string    $table                          Obfuscated id of the desired table. Can be a comma separated list of ids.
     * @param string    $status                         The reservation status.
     * @param string    $notes                          Notes added by the restaurant about the reservation.
     * @param string    $waiter                         Name of the waiter.
     * @param string    $externalReservationId
     * @param string    $additionalData                 JSON encoded list of additional reservation data.
     * @param string    $spam
     * @param string    $remove
     * @param string    $overrideAvailability
     * @param string    $overrideTableChoice
     * @param string    $swappable
     * @param string    $deviceId                       Unique device id to create a temporary reservation lock.
     * @param string    $source
     * @param string    $userId                         Obfuscated Tablemanager user id.
     * @param int       $partnerId                      Id of the reservation partner.
     * @param string    $partnerSource
     * @param boolean   $locked                         Should the tables be locked for this reservation?
     */
    public function __construct(
        $reservationId,
        $restaurantId,
        $guests=null,
        $timeslot=null,
        $endTimeslot=null,
        $duration=null,
        $room=null,
        $table=null,
        $status=null,
        $notes=null,
        $externalReservationId=null,
        $additionalData=null,
        $spam=null,
        $remove=null,
        $overrideAvailability=null,
        $overrideTableChoice=null,
        $swappable=null,
        $deviceId=null,
        $source=null,
        $userId=null,
        $partnerId=null,
        $partnerSource=null,
        $locked=false
    ) {
        $this->reservationId = $reservationId;
        $this->restaurantId = $restaurantId;
        $this->guests = $guests;
        $this->timeslot = $timeslot;
        $this->endTimeslot = $endTimeslot;
        $this->duration = $duration;
        $this->room = isset($room) ? $room : null;
        $this->table = isset($table) ? $table : null;
        $this->status = $status;
        $this->notes = $notes;
        $this->externalReservationId = $externalReservationId;
        $this->additionalData = $additionalData;
        $this->spam = $spam;
        $this->remove = $remove;
        $this->overrideAvailability = $overrideAvailability;
        $this->overrideTableChoice = $overrideTableChoice;
        $this->swappable = $swappable;
        $this->deviceId = $deviceId;
        $this->source = $source;
        $this->userId = isset($userId) ? $userId : null;
        $this->partnerId = isset($partnerId) ? $partnerId : null;
        $this->partnerSource = $partnerSource;
        $this->locked = $locked;
    }

    public function validate(){
        $invalidFields = array();
        if (!isset($this->reservationId)){
            $invalidFields['reservationId'] = $this->reservationId;
        }
        if (!isset($this->restaurantId)){
            $invalidFields['restaurantId'] = $this->restaurantId;
        }
        if (isset($this->guests) && !is_numeric($this->guests)){
            $invalidFields['guests'] = $this->guests;
        }
        if (isset($this->timeslot) && !is_numeric($this->timeslot)){
            $invalidFields['timeslot'] = $this->timeslot;
        }
        if (isset($this->endTimeslot) && !is_numeric($this->endTimeslot)){
            $invalidFields['endTimeslot'] = $this->endTimeslot;
        }
        if (isset($this->duration) && !is_numeric($this->duration)){
            $invalidFields['duration'] = $this->duration;
        }
        if (!empty($this->room) && !is_numeric($this->room)){ // Only check for numeric value if not empty!
            $invalidFields['room'] = $this->room;
        }
        if (isset($this->partnerId) && !is_numeric($this->partnerId)){
            $invalidFields['partnerId'] = $this->partnerId;
        }

        if (!empty($invalidFields)){
            $message = 'Invalid data in ReservationUpdate request object: ' . json_encode($invalidFields) . '.';
            throw new Error\InvalidRequest($message);
            return false;
        }

        return true;
    }

    public function getParams()
    {
        $params = array(
            'reservation_id' => $this->reservationId,
            'restaurant_id' => $this->restaurantId,
            'guests' => $this->guests,
            'timestamp' => $this->timeslot,
            'end_timeslot' => $this->endTimeslot,
            'duration' => $this->duration,
            'room' => $this->room,
            'table' => $this->table,
            'status' => $this->status,
            'notes' => $this->notes,
            'external_reservation_id' => $this->externalReservationId,
            'additional_data' => $this->additionalData,
            'spam' => $this->spam,
            'remove' => $this->remove,
            'overrideAvailability' => $this->overrideAvailability,
            'overrideTableChoice' => $this->overrideTableChoice,
            'swappable' => $this->swappable,
            'device_id' => $this->deviceId,
            'source' => $this->source,
            'user_id' => $this->userId,
            'partner_id' => $this->partnerId,
            'partner_source' => $this->partnerSource,
            'locked' => $this->locked
        );

        $params = array_filter($params, function($val) {
            return isset($val);
        });

        return $params;
    }


}