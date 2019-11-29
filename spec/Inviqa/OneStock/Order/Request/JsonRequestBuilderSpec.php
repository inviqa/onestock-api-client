<?php

namespace spec\Inviqa\OneStock\Order\Request;

use Inviqa\OneStock\Config;
use Inviqa\OneStock\Order\OrderSanitizer;
use Inviqa\OneStock\Order\Request\JsonRequest;
use PhpSpec\ObjectBehavior;
use Services\TestFactory;

class JsonRequestBuilderSpec extends ObjectBehavior
{
    function let(Config $config, OrderSanitizer $sanitizer)
    {
        $this->beConstructedWith($config, $sanitizer);
    }

    function it_delegates_data_sanitation_and_builds_a_request(
        Config $config,
        OrderSanitizer $sanitizer
    )
    {
        $orderParams = TestFactory::fullOrderParams();
        $config->siteId()->willReturn(2);
        $sanitizer->sanitize($orderParams)->willReturn($orderParams);

        $request = new JsonRequest(2, TestFactory::fullOrderObject());

        $this->buildRequestFrom($orderParams)->shouldBeLike($request);
    }
}
