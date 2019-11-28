<?php

namespace spec\Inviqa\OneStock\Order\Request;

use Inviqa\OneStock\Config;
use Inviqa\OneStock\Entity\Address;
use Inviqa\OneStock\Entity\Country;
use Inviqa\OneStock\Entity\Customer;
use Inviqa\OneStock\Entity\Delivery;
use Inviqa\OneStock\Entity\Destination;
use Inviqa\OneStock\Entity\ItemPayment;
use Inviqa\OneStock\Entity\LineItem;
use Inviqa\OneStock\Entity\Order;
use Inviqa\OneStock\Entity\Payment;
use Inviqa\OneStock\Entity\Regions;
use Inviqa\OneStock\Order\OrderSanitizer;
use Inviqa\OneStock\Order\Request\JsonRequest;
use PhpSpec\ObjectBehavior;

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
        $orderParams = $this->createOrderParams();
        $sanitizedParams = ['id' => ''];
        $config->siteId()->willReturn(2);
        $sanitizer->sanitize($orderParams)->willReturn($orderParams);

        $request = new JsonRequest(2, $this->createOrder());

        $this->buildRequestFrom($orderParams)->shouldBeLike($request);
    }

    private function createOrder()
    {
        $customer = new Customer(
            'mr',
                'Janos',
            'Acs',
            '07412313',
            'jacs@inviqa.com'
        );
        $address = new Address(
            ['8', 'Road Lane'],
            'London',
            'SE12313',
            new Regions(new Country('GB')),
            $customer
        );
        $order = new Order(
            '123',
            ['ffs'],
            '1',
            '2',
            new Delivery(new Destination($address)),
            new Payment('GBP', 12.0, 5.0, $address),
            $customer,
            [new LineItem('1', new ItemPayment(12.0))]
        );

        return $order;
    }

    private function createOrderParams()
    {
        $orderParams = [
            'id' => '123',
            'types' => ['ffs'],
            'ruleset_id' => '1',
            'sales_channel' => '2',
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
            'billing_postcode' => 'SE12313',
            'billing_country_code' => 'GB',
            'line_items' => [
                [
                    'item_id' => '1',
                    'item_price' => 12.0,
                ]
            ],
        ];

        return $orderParams;
    }

}
