<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;
use Symfony\Component\Serializer\SerializerInterface;

class HttpClient implements ApiClient
{
    private $client;

    private $authentication;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(ClientInterface $client, array $authentication, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->authentication = $authentication;
        $this->serializer = $serializer;
    }

    public function createOrder(JsonRequest $request): OneStockResponse
    {
        $request = new Request(
            'POST',
            'orders',
            $this->buildHeaders(),
            $this->serializer->serialize($request, 'json')
        );
        $response = $this->client->send($request);

        return new OneStockResponse($request, $response);
    }

    public function request(string $method, string $endpoint, object $request): OneStockResponse
    {
        $request = new Request(
            $method,
            $endpoint,
            $this->buildHeaders(),
            $this->serializer->serialize($request, 'json')
        );
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
}
