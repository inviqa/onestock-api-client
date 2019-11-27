<?php

namespace Inviqa\OneStock\Entity;

class LineItem
{
    public $item_id;
    public $payment;

    public function __construct(string $item_id, ItemPayment $payment)
    {
        $this->item_id = $item_id;
        $this->payment = $payment;
    }
}
