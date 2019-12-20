<?php

namespace Inviqa\OneStock\Entity;

use InvalidArgumentException;

class ItemPayment
{
    public $price;

    public $previous_price;

    public $discount_absolute;

    public $discount_percentage;

    public function __construct($price, $previous_price = null, $discount_absolute = null, $discount_percentage = null)
    {
        $this->setPrice($price);
        $this->setPreviousPrice($previous_price);
        $this->setDiscountAbsolute($discount_absolute);
        $this->setDiscountPercentage($discount_percentage);
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

        $this->previous_price = $value;
    }

    private function assertNumeric($value): void
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException(sprintf('Expected to get numeric value, but got "%s"', $value));
        }
    }

    private function setDiscountAbsolute($value)
    {
        if (!is_null($value)) {
            $this->assertNumeric($value);
        }

        $this->discount_absolute = $value;
    }

    private function setDiscountPercentage($value)
    {
        if (!is_null($value)) {
            $this->assertNumeric($value);
        }

        if ($value > 100 || $value < 0) {
            throw new InvalidArgumentException('Discount percentage value must be a number between 0 and 100.');
        }

        $this->discount_percentage = $value;
    }
}
