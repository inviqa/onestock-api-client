<?php

namespace Inviqa\OneStock\Order;

use Inviqa\OneStock\Order\Exception\RequestParameterException;

class OrderSanitizer
{
    private $requiredFields = [
        'id',
        'sales_channel',
        'currency',
        'price',
        'line_items',
    ];

    private $defaultParams = [
        'first_name' => '',
        'last_name' => '',
        'phone_number' => '',
        'email' => '',
        'title' => '',
        'shipping_amount' => '',
        'shipping_currency' => '',
        'shipping_address_line_1' => '',
        'shipping_city' => '',
        'shipping_postcode' => '',
        'shipping_country_code' => '',
        'billing_address_line_1' => '',
        'billing_city' => '',
        'billing_postcode' => '',
        'billing_country_code' => '',
        'ruleset_id' => '',
        'shipping_address_line_2' => '',
        'billing_address_line_2' => '',
        'types' => ['ffs'],
        'endpoint_id' => '',
    ];

    private $defaultLineItemsParams = [
        'item_id' => '',
        'item_price' => '',
    ];

    public function sanitize(array $orderParams): array
    {
        $orderParams = array_merge($this->defaultParams, $orderParams);

        foreach ($this->requiredFields as $requiredField) {
            $this->validateAttribute($requiredField, $orderParams);
        }

        foreach ($orderParams['line_items'] as $key => $item) {
            $item = array_merge($this->defaultLineItemsParams, $item);

            foreach ($item as $itemKey => $itemValue) {
                $this->validateAttribute($itemKey, $item, 'line item ');
            }
        }

        return $orderParams;
    }

    private function validateAttribute(string $key, $params, string $fieldCustomMessage = ""): void
    {
        if (!isset($params[$key]) || $params[$key] === "") {
            throw new RequestParameterException(sprintf("The %s %sfield is required, but got empty value instead.", $key, $fieldCustomMessage));
        }
    }
}
