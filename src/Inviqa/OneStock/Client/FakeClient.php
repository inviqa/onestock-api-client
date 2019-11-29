<?php

namespace Inviqa\OneStock\Client;

use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;

class FakeClient implements ApiClient
{
    const ORDER_ALREADY_EXISTS_SCENARIO = 'ALREADY EXISTS';
    const AUTH_ERROR_SCENARIO = 'AUTH ERROR';

    public function createOrder(JsonRequest $request): OneStockResponse
    {
        if ($request->order->customer->last_name == self::ORDER_ALREADY_EXISTS_SCENARIO) {
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
        if ($request->order->customer->last_name == self::AUTH_ERROR_SCENARIO) {
            return new OneStockResponse(
                json_encode(
                    [
                        "error" => "auth_error",
                        "message" => "Login or password is incorrect",
                    ]
                )
            );
        }

        return new OneStockResponse(json_encode(['id' => $request->order->id]));
    }
}
