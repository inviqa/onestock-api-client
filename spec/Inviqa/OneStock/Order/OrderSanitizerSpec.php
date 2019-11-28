<?php

namespace spec\Inviqa\OneStock\Order;

use Inviqa\OneStock\Order\Exception\RequestParameterException;
use PhpSpec\ObjectBehavior;

class OrderSanitizerSpec extends ObjectBehavior
{
    function it_throws_an_exception_when_a_required_top_level_field_is_missing()
    {
        $params = $this->testRequestWithoutFields(['id']);

        $this->shouldThrow(RequestParameterException::class)->duringSanitize($params);
    }

    function it_throws_an_exception_when_no_line_items_are_specified()
    {
        $params = $this->testRequestWithoutFields(['line_items']);

        $this->shouldThrow(RequestParameterException::class)->duringSanitize($params);
    }

    function it_throws_an_exception_when_an_invalid_line_item_is_specified()
    {
        $params = $this->testRequestWithoutFields();
        unset($params['line_items'][0]['item_id']);

        $this->shouldThrow(RequestParameterException::class)->duringSanitize($params);
    }

    function it_returns_the_sanitized_order_params_when_optional_fields_are_missing()
    {
        $params = $this->testRequestWithoutFields(['ruleset_id']);
        $sanitizedParams = $params + ['ruleset_id' => ''];

        $this->sanitize($params)->shouldBeLike($sanitizedParams);
    }

    function it_returns_the_sanitized_order_params_when_the_shipping_cost_is_zero()
    {
        $params = $this->testRequestWithoutFields();
        $params['shipping_amount'] = 0.0;

        $this->sanitize($params)->shouldBeLike($params);
    }

    function it_returns_the_sanitized_order_params_when_address_line_two_is_not_set()
    {
        $params = $this->testRequestWithoutFields(['shipping_address_line_2', 'billing_address_line_2']);
        $sanitizedParams = $params + ['shipping_address_line_2' => ''] + ['billing_address_line_2' => ''];

        $this->sanitize($params)->shouldBeLike($sanitizedParams);
    }

    private function testRequestWithoutFields(array $fieldsToRemove = [])
    {
        $orderParams = [
            'id' => '123',
            'ruleset_id' => '1',
            'sales_channel' => '2',
            'types' => '',
            'title' => 'mr',
            'first_name' => 'Janos',
            'last_name' => 'Acs',
            'phone_number' => '07412313',
            'email' => 'jacs@inviqa.com',
            'currency' => 'GBP',
            'price' => 12.0,
            'shipping_amount' => 5.0,
            'shipping_address_line_1' => '8',
            'shipping_address_line_2' => 'Road Lane',
            'shipping_city' => 'London',
            'shipping_postcode' => 'SE12313',
            'shipping_country_code' => 'GB',
            'billing_address_line_1' => '8',
            'billing_address_line_2' => 'Road Lane',
            'billing_city' => 'London',
            'billing_postcode' => 'SE1231',
            'billing_country_code' => 'GB',
            'line_items' => [
                [
                    'item_id' => '1',
                    'item_price' => 12.0,
                ]
            ],
        ];

        foreach ($fieldsToRemove as $field) {
            unset($orderParams[$field]);
        }

        return $orderParams;
    }
}
