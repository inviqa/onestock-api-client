<?php

namespace Inviqa\OneStock\Entity;

class ShippingCarrier
{
    public $name;
    public $option;

    public function __construct(string $name, string $option)
    {
        $this->name = $name;
        $this->option = $option;
    }
}
