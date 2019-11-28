<?php

namespace Inviqa\OneStock\Entity;

class Order
{
    public $id;
    public $types;
    public $ruleset_id;
    public $sales_channel;
    public $delivery;
    public $payment;
    public $customer;
    public $line_items;

    /**
     * Order constructor.
     *
     * @param LineItem[] $line_items
     */
    public function __construct(
        string $id,
        array $types,
        string $ruleset_id,
        string $sales_channel,
        Delivery $delivery,
        Payment $payment,
        Customer $customer,
        array $line_items
    ) {
        $this->id = $id;
        $this->types = $types;
        $this->ruleset_id = $ruleset_id;
        $this->sales_channel = $sales_channel;
        $this->delivery = $delivery;
        $this->payment = $payment;
        $this->customer = $customer;
        $this->line_items = $line_items;
    }
}
