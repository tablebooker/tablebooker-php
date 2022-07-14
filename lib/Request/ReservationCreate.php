<?php

namespace Tablebooker\Request;

use bar\baz\source_with_namespace;
use Tablebooker\Error;

class ReservationCreate implements RequestResource
{
    protected $restaurantId;
    protected $guests;
    protected $timeslot;
    protected $endTimeslot;
    protected $duration;
    protected $deviceId;
    protected $source;
    protected $partnerId;
    protected $partnerSource;
    protected $couponId;
    protected $couponCode;
    protected $promotionId;
    protected $walkin;
    /**
     * @var ReservationCreateCustomer
     */
    protected $customer;
    protected $notes;
    protected $externalReservationId;
    protected $additionalData;
    protected $room;
    protected $table;
    protected $userInfo;
    protected $waiter;
    protected $manualnotification_sms;
    protected $manualnotification_email;
    protected $authorized_data;
    protected $authorized_promo;
    protected $authorized_partner_data;
    protected $userId;
    protected $locked;

    /**
     * Creates a new ReservationCreate Request entity, used for creation of a new reservation.

     * @param string    $restaurantId                   Required. Obfuscated Tablebooker restaurant id.
     * @param int       $guests                         Required. Number of guests to make a reservation for.
     * @param int       $timeslot                       Required. Date and time of the reservation. Unix timestamp
     * @param int       $endTimeslot                    Date and time when the reservation ends. Unix timestamp
     * @param int       $duration
     * @param string    $deviceId
     * @param string    $source
     * @param int       $partnerId                      Id of the reservation partner.
     * @param string    $partnerSource
     * @param string    $couponId                       Obfuscated id of a selected coupon capacity (type of coupon)
     * @param string    $couponCode                     Code for the selected coupon.
     * @param string    $promotionId                    Obfuscated id of a selected promotion
     * @param boolean   $walkin
     * @param ReservationCreateCustomer $customer       Customer data
     * @param string    $notes                          Notes added by the restaurant about the reservation.
     * @param string    $externalReservationId
     * @param string    $additionalData                 JSON encoded list of additional reservation data.
     * @param string    $room                           Obfusctaed id of the desired room.
     * @param string    $table                          Obfuscated id of the desired table. Can be a comma separated list of ids.
     * @param string    $userInfo                       JSON string with information about the person making the reservation (ip address, request url, device/browser info, ...
     * @param string    $waiter                         Name of the waiter who created this reservation.
     * @param boolean   $manualnotification_sms         Indicate if an extra notification has to be send by SMS.
     * @param boolean   $manualnotification_email       Indicate if an extra notification has to be send by email.
     * @param boolean   $authorized_data                Indicate if a customer authorized data access, GDPR.
     * @param boolean   $authorized_promo               Indicate if a customer authorized promos to be send, GDPR.
     * @param boolean   $authorized_partner_data        Indicate if a customer authorized data access to a promo.
     * @param string    $userId                         Obfuscated Tablemanager user id.
     * @param boolean   $locked                         Should the tables be locked for this reservation?
     */
    public function __construct(
        $restaurantId,
        $guests,
        $timeslot,
        $endTimeslot=null,
        $duration=null,
        $deviceId=null,
        $source=null,
        $partnerId=null,
        $partnerSource=null,
        $couponId=null,
        $couponCode=null,
        $promotionId=null,
        $walkin=false,
        ReservationCreateCustomer $customer=null,
        $notes=null,
        $externalReservationId=null,
        $additionalData=null,
        $room=null,
        $table=null,
        $userInfo=null,
        $waiter=null,
        $manualnotification_sms=false,
        $manualnotification_email=false,
        $authorized_data=false,
        $authorized_promo=false,
        $authorized_partner_data=false,
        $userId=null,
        $locked=false
    ) {
        $this->restaurantId = $restaurantId;
        $this->guests = $guests;
        $this->timeslot = $timeslot;
        $this->endTimeslot = $endTimeslot;
        $this->duration = $duration;
        $this->deviceId = $deviceId;
        $this->source = $source;
        $this->partnerId = !empty($partnerId) ? $partnerId : null;
        $this->partnerSource = $partnerSource;
        $this->couponId = !empty($couponId) ? $couponId : null;
        $this->couponCode = $couponCode;
        $this->promotionId = !empty($promotionId) ? $promotionId : null;
        $this->walkin = $walkin;
        $this->customer = $customer;
        $this->notes = $notes;
        $this->externalReservationId = $externalReservationId;
        $this->additionalData = $additionalData;
        $this->room = !empty($room) ? $room : null;
        $this->table = !empty($table) ? $table : null;
        $this->userInfo = $userInfo;
        $this->waiter = $waiter;
        $this->manualnotification_sms = $manualnotification_sms;
        $this->manualnotification_email = $manualnotification_email;
        $this->authorized_data = $authorized_data;
        $this->authorized_promo = $authorized_promo;
        $this->authorized_partner_data = $authorized_partner_data;
        $this->userId = !empty($userId) ? $userId : null;
        $this->locked = $locked;
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
        if (isset($this->endTimeslot) && !is_numeric($this->endTimeslot)){
            $invalidFields['endTimeslot'] = $this->endTimeslot;
        }
        if (isset($this->duration) && !is_numeric($this->duration)){
            $invalidFields['duration'] = $this->duration;
        }
        if (isset($this->partnerId) && !is_numeric($this->partnerId)){
            $invalidFields['partnerId'] = $this->partnerId;
        }
        if (isset($this->customer)){
            $invalidFields = array_merge($invalidFields, $this->customer->getInvalidFields());
        }

        if (!empty($invalidFields)){
            $message = 'Invalid data in ReservationCreate request object: ' . json_encode($invalidFields) . '.';
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
            'end_timeslot' => $this->endTimeslot,
            'duration' => $this->duration,
            'device_id' => $this->deviceId,
            'source' => $this->source,
            'partner_id' => $this->partnerId,
            'partner_source' => $this->partnerSource,
            'coupon_id' => $this->couponId,
            'coupon_code' => $this->couponCode,
            'promotion_id' => $this->promotionId,
            'walkin' => $this->walkin,
            'notes' => $this->notes,
            'external_reservation_id' => $this->externalReservationId,
            'additional_data' => $this->additionalData,
            'room' => $this->room,
            'table' => $this->table,
            'user_info' => $this->userInfo,
            'waiter' => $this->waiter,
            'manualnotification_sms' => $this->manualnotification_sms,
            'manualnotification_email' => $this->manualnotification_email,
            'authorized_data' => $this->authorized_data,
            'authorized_promo' => $this->authorized_promo,
            'authorized_partner_data' => $this->authorized_partner_data,
            'user_id' => $this->userId,
            'locked' => $this->locked
        );

        $params = array_merge($params, $this->customer->getParams());

        $params = array_filter($params, function($val) {
            return isset($val);
        });

        return $params;
    }


}