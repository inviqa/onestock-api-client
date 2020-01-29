<?php

namespace Inviqa\OneStock\Entity;

class UpdatedLineItem
{
    public $payment;
    public $delivery;
    public $from;
    public $to;
    public $information;

    public function __construct(
        ItemPayment $payment = null,
        ItemDelivery $delivery = null,
        string $from = null,
        string $to = null,
        array $information = []
    ) {
        $this->payment = $payment;
        $this->delivery = $delivery;
        $this->from = $from;
        $this->to = $to;
        $this->information = $information;
    }
}
