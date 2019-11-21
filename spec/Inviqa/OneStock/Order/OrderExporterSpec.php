<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\Order\OrderExporter;
use PhpSpec\ObjectBehavior;

class OrderExporterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OrderExporter::class);
    }
}
