<?php

namespace Inviqa\OneStock\Entity;

class LineItem
{
    public $id;
    public $item_id;
    public $payment;
    public $delivery;

    public function __construct(
        string $id,
        string $item_id,
        ItemPayment $payment = null,
        ItemDelivery $delivery = null
    ) {
        $this->id = $id;
        $this->item_id = $item_id;
        $this->payment = $payment;
        $this->delivery = $delivery;
    }
}
