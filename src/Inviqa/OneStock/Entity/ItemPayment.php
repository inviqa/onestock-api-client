<?php

namespace Inviqa\OneStock\Entity;

use InvalidArgumentException;

class ItemPayment
{
    public $price;

    public function __construct($price)
    {
        $this->setPrice($price);
    }

    private function setPrice($price): void
    {
        if (!is_numeric($price)) {
            throw new InvalidArgumentException(sprintf('Expected to get numeric value, but got "%s"', $price));
        }

        $this->price = $price;
    }
}
