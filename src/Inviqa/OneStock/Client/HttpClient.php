<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;

class HttpClient implements ApiClient
{
    private $client;
    private $authentication;

    public function __construct(ClientInterface $client, array $authentication)
    {
        $this->client = $client;
        $this->authentication = $authentication;
    }

    public function createOrder(JsonRequest $request): OneStockResponse
    {
        $response = $this->client->request('POST', 'orders', [
            'headers' => [
                'Auth-User' => $this->authentication['username'],
                'Auth-Password' => $this->authentication['password'],
            ],
            'body' => json_encode($request),
        ]);

        return new OneStockResponse($response->getBody()->getContents());
    }
}
