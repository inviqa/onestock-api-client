<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\Entity\Order;
use PhpSpec\ObjectBehavior;

class OrderConverterSpec extends ObjectBehavior
{
    function it_returns_an_order_instance()
    {
        $this->convert([])->shouldBeAnInstanceOf(Order::class);
    }
}
