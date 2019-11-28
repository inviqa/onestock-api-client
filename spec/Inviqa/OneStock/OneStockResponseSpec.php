<?php

namespace spec\Inviqa\OneStock;

use PhpSpec\ObjectBehavior;

class OneStockResponseSpec extends ObjectBehavior
{
    function it_is_successful_if_the_response_text_contains_an_order_id()
    {
        $response = json_encode(['id' => '1234']);

        $this->beConstructedWith($response);
        $this->isSuccess()->shouldBe(true);
    }
}
