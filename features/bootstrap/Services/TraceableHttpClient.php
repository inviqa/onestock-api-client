<?php

namespace Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use LogicException;
use GuzzleHttp\ClientInterface;

class TraceableHttpClient implements ClientInterface
{

    /**
     * @var ClientInterface
     */
    private $decoratedClient;

    public function __construct(ClientInterface $decoratedClient)
    {
        $this->decoratedClient = $decoratedClient;
    }

    /**
     * @var RequestInterface
     */
    private $lastRequest;

    public function send(RequestInterface $request, array $options = [])
    {
        $this->lastRequest = $request;

        return $this->decoratedClient->send($request);
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
        $this->createMethodNotImplementedException(__METHOD__);
    }

    public function request($method, $uri, array $options = [])
    {
        $this->createMethodNotImplementedException(__METHOD__);
    }

    public function requestAsync($method, $uri, array $options = [])
    {
        $this->createMethodNotImplementedException(__METHOD__);
    }

    public function getConfig($option = null)
    {
        $this->createMethodNotImplementedException(__METHOD__);
    }

    private function createMethodNotImplementedException(string $methodName): void
    {
        throw new LogicException(sprintf('The method %s has not been implemented yet.', $methodName));
    }


    public function getLastRequest(): RequestInterface
    {
        return $this->lastRequest;
    }

}
