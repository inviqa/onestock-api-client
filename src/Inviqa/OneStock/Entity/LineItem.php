<?php

namespace Inviqa\OneStock\Entity;

class LineItem
{
    public $item_id;
    public $payment;
    public $delivery;
    public $from;
    public $to;

    public function __construct(
        string $item_id,
        ItemPayment $payment,
        ItemDelivery $delivery = null,
        string $from = null,
        string $to = null
    ) {
        $this->item_id = $item_id;
        $this->payment = $payment;
        $this->delivery = $delivery;
        $this->from = $from;
        $this->to = $to;
    }
}
