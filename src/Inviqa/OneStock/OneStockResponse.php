<?php

namespace Inviqa\OneStock;

class OneStockResponse
{
    private $success;
    private $response;

    public function __construct(string $response)
    {
        $this->response = json_decode($response, true);
        $this->success = !empty($this->response['id']);
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getErrorId()
    {
        $error = $this->getError();
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
        $error = $this->getError();
        if (isset($error['message'])) {
            return $error['message'];
        }

        return "API Error: " . $this->getErrorId();
    }

    public function getErrorEntityType()
    {
        $error = $this->getError();
        if (isset($error['params'])) {
            return $error['params']['entity'];
        }

        return '';
    }

    public function getErrorEntityId()
    {
        $error = $this->getError();
        if (isset($error['params'])) {
            return $error['params']['id'];
        }

        return '';
    }

    public function getErrorCode()
    {
        $error = $this->getError();
        $statusCode = 400;
        if (isset($error['code'])) {
            $statusCode = $error['code'];
        }

        return $statusCode;
    }

    private function getError()
    {
        if (!$this->success) {
            return $this->response;
        }

        return [];
    }
}
