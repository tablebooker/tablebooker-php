<?php


namespace Tablebooker\Request;

use Tablebooker\Error;

class RestaurantSendMessage implements RequestResource
{
    /**
     * RestaurantSendMessage constructor.
     * @param $restaurantId
     * @param $senderName
     * @param $senderEmail
     * @param $subject
     * @param $message
     * @param null $reservationId
     */
    public function __construct($restaurantId, $senderName, $senderEmail, $subject, $message, $reservationId = null)
    {
        $this->reservationId = $reservationId;
        $this->restaurantId = $restaurantId;
        $this->senderName = $senderName;
        $this->senderEmail = $senderEmail;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * @return bool
     * @throws Error\InvalidRequest
     */
    public function validate(){
        $invalidFields = array();
        if (!is_numeric($this->restaurantId)){
            $invalidFields['restaurantId'] = $this->restaurantId;
        }

        if (!empty($invalidFields)){
            $message = 'Invalid data in RestaurantSendMessage request object: ' . json_encode($invalidFields) . '.';
            throw new Error\InvalidRequest($message);
            return false;
        }

        return true;
    }

    /**
     * Get the parameters to send to the API
     * @return array
     */
    public function getParams()
    {
        $params = array(
            'tablebooker_id' => $this->restaurantId,
            'sender_name' => $this->senderName,
            'sender_email' => $this->senderEmail,
            'subject' => $this->subject,
            'message' => $this->message,
        );
        if (!empty($this->reservationId)) {
            $params['reservation_id'] = $this->reservationId;
        }

        return $params;
    }
}