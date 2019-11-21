<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\Client\ApiClientFactory;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\OrderExporter;
use PhpSpec\ObjectBehavior;

/**
 * @mixin OrderExporter
 */
class OrderExporterSpec extends ObjectBehavior
{
    function it_can_export_an_order()
    {
        $this->export()->shouldHaveType(OneStockResponse::class);
    }
}
