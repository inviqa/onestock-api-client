<?php

namespace Inviqa\OneStock\Entity;

class ItemDelivery
{
    public $tracking_code;
    public $carrier;

    public function __construct(string $tracking_code, ShippingCarrier $carrier)
    {
        $this->tracking_code = $tracking_code;
        $this->carrier = $carrier;
    }
}
