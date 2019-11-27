<?php

namespace Inviqa\OneStock\Entity;

class Payment
{
    public $currency = '';
    public $price = 0.0;
    public $shipping_price = 0.0;
    public $address;

    public function __construct(
        string $currency,
        float $price,
        float $shipping_price,
        Address $address
    ) {
        $this->currency = $currency;
        $this->price = $price;
        $this->shipping_price = $shipping_price;
        $this->address = $address;
    }
}
