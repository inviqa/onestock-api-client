<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use Inviqa\OneStock\LineUpdater\LineItemUpdateRequest;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;

class HttpClient
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
        $response = $this->client->request('POST', 'orders', $this->buildRequest($request));

        return new OneStockResponse($response->getBody()->getContents());
    }

    public function updateLineItems(LineItemUpdateRequest $request): OneStockResponse
    {
        $response = $this->client->request('PATCH', 'multi/line_items', $this->buildRequest($request));

        return new OneStockResponse($response->getBody()->getContents());
    }

    private function buildHeaders(): array
    {
        return [
            'Auth-User' => $this->authentication['username'],
            'Auth-Password' => $this->authentication['password'],
        ];
    }

    private function buildRequest(object $request): array
    {
        return [
            'headers' => $this->buildHeaders(),
            'body' => json_encode($request),
        ];
    }
}
