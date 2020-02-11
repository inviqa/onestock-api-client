<?php

namespace Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Inviqa\OneStock\OneStockResponse;
use Inviqa\OneStock\Order\Request\JsonRequest;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $serializer = $this->createSerializer();
        $request = new Request('POST', 'orders', $this->buildHeaders(), $serializer->serialize($request, 'json'));
        $response = $this->client->send($request);

        return new OneStockResponse($request, $response);
    }

    public function request(string $method, string $endpoint, object $request): OneStockResponse
    {
        $serializer = $this->createSerializer();
        $request = new Request($method, $endpoint, $this->buildHeaders(), $serializer->serialize($request, 'json'));
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

    private function createSerializer(): Serializer
    {
        $arrayCallback = function ($innerObject) {
            return is_array($innerObject) && empty($innerObject) ? null : $innerObject;
        };

        return new Serializer([new ObjectNormalizer(null, null, null, null, null, null, [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            AbstractNormalizer::CALLBACKS => [
                'information' => $arrayCallback,
                'types' => $arrayCallback,
            ],
        ])], [new JsonEncoder()]);
    }
}
