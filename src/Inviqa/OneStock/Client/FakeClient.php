<?php

namespace Inviqa\OneStock\Client;

use Inviqa\OneStock\Config;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;
use RuntimeException;

class FakeClient implements ApiClient
{
    const ORDER_ALREADY_EXISTS_SCENARIO = 'ALREADY EXISTS';
    const AUTH_ERROR_SCENARIO = 'AUTH ERROR';

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function createOrder(JsonRequest $request): OneStockResponse
    {
        $extraParameters = $this->config->extraParameters();

        if (!isset($extraParameters['testOrders'])) {
            throw new RuntimeException('The test configuration does not reference any test orders');
        }

        if (!empty($extraParameters['error'])) {
            return new OneStockResponse(
                json_encode(
                    [
                        "error" => "test",
                        "message" => $extraParameters['error'],
                    ]
                )
            );
        }

        foreach ($extraParameters['testOrders'] as $testOrderId) {
            if ($testOrderId == $request->order->id) {
                return new OneStockResponse(
                    json_encode(
                        [
                            "code" => 409,
                            "name" => "already_exists",
                            "params" => [
                                "entity" => "order",
                                "id" => $request->order->id,
                                "request" => "order/create",
                            ],
                        ]
                    )
                );
            }
        }

        return new OneStockResponse(json_encode(['id' => $request->order->id]));
    }
}
