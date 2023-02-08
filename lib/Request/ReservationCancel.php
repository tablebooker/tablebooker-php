<?php

namespace Tablebooker\Request;

use Tablebooker\Error;

class ReservationCancel implements RequestResource
{
    protected $reservationId;
    protected $restaurantId;
    protected $userId;
    protected $status;
    protected $waiter;
    protected $refundType;
    protected $refundAmount;
    protected $spam;
    protected $chargeGuarantee;
    protected $overrideAvailability;
    protected $source;
    protected $message;

    /**
     * ReservationCancel constructor.
     * Creates a new ReservationCancel Request entity.
     * @param string $reservationId Obfuscated reservation id
     * @param string $restaurantId Obfuscated restaurant id
     * @param string|null $userId Obfuscated user id
     * @param string|null $status Status
     * @param string|null $waiter Waiter name
     * @param bool|null $refundType Refund type. One of 'full', 'default', 'none' or 'custom'
     * @param int|null $refundAmount The amount to be refunded
     * @param bool|null $spam Mark reservation as spam
     * @param bool|null $chargeGuarantee Charge the guarantee for no shows
     * @param bool $overrideAvailability
     * @param string|null $source The source application of this change
     * @param string|null $message An explanation to send to the customer
     */
    public function __construct($reservationId, $restaurantId, $userId=null, $status=null, $waiter=null, $refundType=null, $refundAmount=0, $spam=null, $chargeGuarantee=null, $overrideAvailability=false, $source=null, $message=null)
    {
        $this->reservationId = $reservationId;
        $this->restaurantId = $restaurantId;
        $this->userId = $userId;
        $this->status = $status;
        $this->waiter = $waiter;
        $this->refundType = $refundType;
        $this->refundAmount = $refundAmount;
        $this->spam = $spam;
        $this->chargeGuarantee = $chargeGuarantee;
        $this->overrideAvailability = $overrideAvailability;
        $this->source = isset($source)?$source:null;
        $this->message = !empty($message)?$message:null;
    }

    public function validate(){
        $invalidFields = array();
        if (!is_numeric($this->reservationId)){
            $invalidFields['reservationId'] = $this->reservationId;
        }
        if (!is_numeric($this->restaurantId)){
            $invalidFields['restaurantId'] = $this->restaurantId;
        }
        if (isset($this->userId) && !is_numeric($this->userId)){
            $invalidFields['userId'] = $this->userId;
        }

        if (!empty($invalidFields)){
            $message = 'Invalid data in ReservationCancel request object: ' . json_encode($invalidFields) . '.';
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
            'user_id' => $this->userId,
            'status' => $this->status,
            'waiter' => $this->waiter,
            'refund_type' => $this->refundType,
            'refund_amount' => $this->refundAmount,
            'spam' => $this->spam,
            'charge_guarantee' => $this->chargeGuarantee,
            'overrideAvailability' => $this->overrideAvailability,
            'source' => $this->source,
            'message' => $this->message,
        );

        return $params;
    }

    /**
     * @return mixed
     */
    public function getReservationId()
    {
        return $this->reservationId;
    }

}