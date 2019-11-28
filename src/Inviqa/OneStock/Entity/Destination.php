<?php

namespace Inviqa\OneStock\Entity;

class Destination
{
    public $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }
}
