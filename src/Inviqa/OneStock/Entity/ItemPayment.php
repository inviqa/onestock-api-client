<?php

namespace Inviqa\OneStock\Entity;

class ItemPayment
{
    public $price;

    public function __construct(float $price)
    {
        $this->price = $price;
    }
}
