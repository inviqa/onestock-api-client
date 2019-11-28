<?php

namespace Inviqa\OneStock\Entity;

class Delivery
{
    public $destination;

    public function __construct(Destination $destination)
    {
        $this->destination = $destination;
    }
}
