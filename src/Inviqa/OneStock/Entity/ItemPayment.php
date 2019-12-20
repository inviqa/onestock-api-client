<?php

namespace Inviqa\OneStock\Entity;

use InvalidArgumentException;

class ItemPayment
{
    public $price;

    private $previousPrice;

    public function __construct($price, $previous_price = null)
    {
        $this->setPrice($price);
        $this->setPreviousPrice($previous_price);
    }

    private function setPrice($value): void
    {
        $this->assertNumeric($value);

        $this->price = $value;
    }

    private function setPreviousPrice($value): void
    {
        if (!is_null($value)) {
            $this->assertNumeric($value);
        }

        $this->previousPrice = $value;
    }

    private function assertNumeric($value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(sprintf('Expected to get numeric value, but got "%s"', $value));
        }
    }
}
