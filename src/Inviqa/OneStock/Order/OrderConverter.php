<?php

namespace Inviqa\OneStock\Order;

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

class OrderConverter
{
    public function convert(array $orderParams)
    {
        $defaultTypes = ['ffs'];

        return new Order(
            $orderParams['id'],
            $defaultTypes,
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
        $shipping = $orderParams['shipping_address'];
        $address = $this->createAddressFromOrderAddress(
            $shipping,
            $this->createCustomerFromOrderParams($orderParams)
        );

        return new Delivery(new Destination($address));
    }

    private function createCustomerFromOrderParams(array $orderParams)
    {
        return new Customer(
            '',
            $orderParams['customer_first_name'],
            $orderParams['customer_last_name'],
            $orderParams['phone_number'],
            $orderParams['email']
        );
    }

    private function createPaymentFromOrderParams(array $orderParams)
    {
        $payment = $orderParams['payment'];
        $billing_address = $orderParams['billing_address'];

        return new Payment(
            $payment['currency'],
            $payment['price'],
            $payment['shipping_amount'],
            $this->createAddressFromOrderAddress(
                $billing_address,
                $this->createCustomerFromOrderParams($orderParams)
            )
        );
    }

    private function createAddressFromOrderAddress(array $addressData, $customer)
    {
        return new Address(
            [$addressData['address_line_1'], $addressData['address_line_2']],
            $addressData['city'],
            $addressData['postcode'],
            new Regions(new Country($addressData['country_code'])),
            $customer
        );
    }

    private function createLineItemsFromOrderParams(array $orderParams)
    {
        $lineItems = [];

        foreach ($orderParams['line_items'] as $item) {
            $lineItems[] = new LineItem($item['item_id'], new ItemPayment($item['price']));
        }

        return $lineItems;
    }
}
