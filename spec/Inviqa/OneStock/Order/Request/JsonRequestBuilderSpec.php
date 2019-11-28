<?php

namespace spec\Inviqa\OneStock\Order\Request;

use Inviqa\OneStock\Config;
use Inviqa\OneStock\Entity\Order;
use Inviqa\OneStock\Order\OrderConverter;
use Inviqa\OneStock\Order\OrderSanitizer;
use Inviqa\OneStock\Order\Request\JsonRequest;
use PhpSpec\ObjectBehavior;

class JsonRequestBuilderSpec extends ObjectBehavior
{
    function let(Config $config, OrderSanitizer $sanitizer, OrderConverter $converter)
    {
        $this->beConstructedWith($config, $sanitizer, $converter);
    }

    function it_delegates_data_sanitation_and_order_instantiation(
        Config $config,
        OrderSanitizer $sanitizer,
        OrderConverter $converter,
        Order $order
    )
    {
        $orderParams = [];
        $sanitizedParams = ['id' => ''];
        $config->siteId()->willReturn(2);

        $sanitizer->sanitize($orderParams)->willReturn($sanitizedParams);
        $converter->convert($sanitizedParams)->willReturn($order);

        $request = new JsonRequest(2, $order->getWrappedObject());
        $this->buildRequestFrom($orderParams)->shouldBeLike($request);
    }

}
