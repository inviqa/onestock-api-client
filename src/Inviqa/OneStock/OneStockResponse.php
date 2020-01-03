<?php

namespace Inviqa\OneStock;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class OneStockResponse
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function isSuccess(): bool
    {
        return substr((string) $this->response->getStatusCode(), 0, 1) === '2';
    }

    /**
     * @return string
     */
    public function getErrorId()
    {
        $error = $this->getResponseBodyAsArray();
        $errorId = 0;
        if (isset($error['name'])) {
            $errorId = $error['name'];
        }
        if (isset($error['error'])) {
            $errorId = $error['error'];
        }

        return $errorId;
    }

    public function getErrorMessage()
    {
        $error = $this->getResponseBodyAsArray();
        if (isset($error['message'])) {
            return $error['message'];
        }

        return "API Error: " . $this->getErrorId();
    }

    public function getErrorEntityType()
    {
        $error = $this->getResponseBodyAsArray();
        if (isset($error['params'])) {
            return $error['params']['entity'];
        }

        return '';
    }

    public function getErrorEntityId()
    {
        $error = $this->getResponseBodyAsArray();
        if (isset($error['params'])) {
            return $error['params']['id'];
        }

        return '';
    }

    public function getErrorCode()
    {
        $error = $this->getResponseBodyAsArray();
        $statusCode = 400;
        if (isset($error['code'])) {
            $statusCode = $error['code'];
        }

        return $statusCode;
    }

    public function request(): RequestInterface
    {
        return $this->request;
    }

    public function response(): ResponseInterface
    {
        return $this->response;
    }

    private function getResponseBodyAsArray(): array
    {
        return json_decode($this->response->getBody()->__toString(), true);
    }
}
