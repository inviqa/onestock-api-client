<?php

namespace Inviqa\OneStock\Entity;

class Destination
{
    public $address;

    public $endpoint_id;

    public function __construct(Address $address, string $endpoint_id)
    {
        $this->address = $address;
        $this->endpoint_id = $endpoint_id;
    }
}
