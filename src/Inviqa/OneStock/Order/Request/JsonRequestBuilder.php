<?php

namespace Inviqa\OneStock\Order\Request;

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

class JsonRequestBuilder
{
    private $config;
    private $sanitizer;

    public function __construct(Config $config, OrderSanitizer $sanitizer)
    {
        $this->config = $config;
        $this->sanitizer = $sanitizer;
    }

    public function buildRequestFrom($orderParams)
    {
        $sanitizedParams = $this->sanitizer->sanitize($orderParams);
        $order = $this->convertOrder($sanitizedParams);

        return new JsonRequest($this->config->siteId(), $order);
    }

    private function convertOrder(array $orderParams)
    {
        return new Order(
            $orderParams['id'],
            $orderParams['types'],
            $orderParams['ruleset_id'],
            $orderParams['sales_channel'],
            $this->createDeliveryFromOrderParams($orderParams),
            $this->createPaymentFromOrderParams($orderParams),
            $this->createCustomerFromOrderParams($orderParams),
            $this->createLineItemsFromOrderParams($orderParams)
        );
    }

    private function createDeliveryFromOrderParams(array $orderParams)
    {
        $address = $this->createAddressFromOrderAddress('shipping', $orderParams);

        return new Delivery(new Destination($address));
    }

    private function createCustomerFromOrderParams(array $orderParams)
    {
        return new Customer(
            $orderParams['title'],
            $orderParams['first_name'],
            $orderParams['last_name'],
            $orderParams['phone_number'],
            $orderParams['email']
        );
    }

    private function createPaymentFromOrderParams(array $orderParams)
    {
        return new Payment(
            $orderParams['currency'],
            $orderParams['price'],
            $orderParams['shipping_amount'],
            $this->createAddressFromOrderAddress('billing', $orderParams)
        );
    }

    private function createAddressFromOrderAddress(string $prefix, array $orderParams)
    {
        return new Address(
            [$orderParams[$prefix . '_address_line_1'], $orderParams[$prefix . '_address_line_2']],
            $orderParams[$prefix . '_city'],
            $orderParams[$prefix . '_postcode'],
            new Regions(new Country($orderParams[$prefix . '_country_code'])),
            $this->createCustomerFromOrderParams($orderParams)
        );
    }

    private function createLineItemsFromOrderParams(array $orderParams)
    {
        $lineItems = [];
        foreach ($orderParams['line_items'] as $item) {
            $lineItems[] = new LineItem($item['item_id'], new ItemPayment($item['item_price']));
        }

        return $lineItems;
    }
}
