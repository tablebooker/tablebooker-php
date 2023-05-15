<?php

namespace Tablebooker\Request;

use Tablebooker\Error;

class RestaurantInfo implements RequestResource
{
    protected $restaurantId;    // string, required
    protected $source;          // string
    protected $partnerId;       // string

    /**
     * Creates a new RestaurantInfo Request entity.
     * @param string $restaurantId
     * @param string|null $source
     * @param string|null $partnerId
     */
    public function __construct(
        $restaurantId,
        $source = null,
        $partnerId = null
    ) {
        $this->restaurantId = $restaurantId;
        $this->source = $source;
        $this->partnerId = $partnerId;
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

        if (!empty($invalidFields)) {
            $message = 'Invalid data in RestaurantInfo request object: '.json_encode($invalidFields).'.';
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
            'tablebooker_id' => $this->restaurantId,
            'source' => $this->source,
            'partner_id' => $this->partnerId,
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