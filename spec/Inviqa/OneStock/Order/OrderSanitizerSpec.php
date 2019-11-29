<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\Order\Exception\RequestParameterException;
use PhpSpec\ObjectBehavior;
use Services\TestFactory;

class OrderSanitizerSpec extends ObjectBehavior
{
    function it_throws_an_exception_when_a_required_top_level_field_is_missing()
    {
        $params = TestFactory::orderParamsWithoutFields(['id']);

        $this->shouldThrow(RequestParameterException::class)->duringSanitize($params);
    }

    function it_throws_an_exception_when_no_line_items_are_specified()
    {
        $params = TestFactory::orderParamsWithoutFields(['line_items']);

        $this->shouldThrow(RequestParameterException::class)->duringSanitize($params);
    }

    function it_throws_an_exception_when_an_invalid_line_item_is_specified()
    {
        $params = TestFactory::orderParamsWithoutFields();
        unset($params['line_items'][0]['item_id']);

        $this->shouldThrow(RequestParameterException::class)->duringSanitize($params);
    }

    function it_returns_the_sanitized_order_params_when_optional_fields_are_missing()
    {
        $params = TestFactory::orderParamsWithoutFields(['ruleset_id']);
        $sanitizedParams = $params + ['ruleset_id' => ''];

        $this->sanitize($params)->shouldBeLike($sanitizedParams);
    }

    function it_returns_the_sanitized_order_params_when_the_shipping_cost_is_zero()
    {
        $params = TestFactory::orderParamsWithoutFields();
        $params['shipping_amount'] = 0.0;

        $this->sanitize($params)->shouldBeLike($params);
    }

    function it_returns_the_sanitized_order_params_when_address_line_two_is_not_set()
    {
        $params = TestFactory::orderParamsWithoutFields(['shipping_address_line_2', 'billing_address_line_2']);
        $sanitizedParams = $params + ['shipping_address_line_2' => ''] + ['billing_address_line_2' => ''];

        $this->sanitize($params)->shouldBeLike($sanitizedParams);
    }
}
