<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\OrderExporterFactory;
use Inviqa\OneStock\Order\OrderExporter;
use PhpSpec\ObjectBehavior;

class OrderExporterFactorySpec extends ObjectBehavior
{
    function it_creates_an_order_exporter(Config $config)
    {
        $this::createFromConfig($config)->shouldBeAnInstanceOf(OrderExporter::class);
    }
}
