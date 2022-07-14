<?php

namespace Tablebooker\Request;

interface RequestResource
{
    /**
     * Validate the request data.
     *
     * @throws Error\InvalidRequest when the RequestResource is not valid
     */
    public function validate();

    /**
     * Get the actual array with request params that will be send to the API.
     */
    public function getParams();
}