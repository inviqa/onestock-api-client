<?php

namespace Inviqa\OneStock\Entity;

class UpdatedLineItem
{
    public $payment;
    public $delivery;
    public $from;
    public $to;

    public function __construct(
        ItemPayment $payment = null,
        ItemDelivery $delivery = null,
        string $from = null,
        string $to = null
    ) {
        $this->payment = $payment;
        $this->delivery = $delivery;
        $this->from = $from;
        $this->to = $to;
    }
}
