<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
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
        $request = new Request('POST', 'orders', $this->buildHeaders(), json_encode($request));
        $response = $this->client->send($request);

        return new OneStockResponse($request, $response);
    }

    public function request(string $method, string $endpoint, object $request): OneStockResponse
    {
        $request = new Request($method, $endpoint, $this->buildHeaders(), json_encode($this->removeEmpty((array) $request)));
        $response = $this->client->send($request);

        return new OneStockResponse($request, $response);
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

    private function removeEmpty(array $request)
    {
        foreach ($request as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $request[$key] = $this->removeEmpty((array) $value);
            }
            if (empty($request[$key])) {
                unset($request[$key]);
            }
        }

        return $request;
    }
}
