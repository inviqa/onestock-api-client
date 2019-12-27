<?php

namespace Services;

use Inviqa\OneStock\Application;
use Inviqa\OneStock\Config;
use Inviqa\OneStock\OneStockException;

class TestApplicationProxy
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var \Inviqa\OneStock\OneStockResponse|null
     */
    private $lastApiResponse;

    /**
     * @var \Exception|OneStockException|null
     */
    private $lastApiException;

    public function __construct(Config $config)
    {
        $this->application = new Application($config);
    }

    public function updateLineItems(array $lineItemUpdateParameters)
    {
        try {
            $this->lastApiResponse = $this->application->updateLineItems($lineItemUpdateParameters);
        } catch (OneStockException $e) {
            $this->lastApiException = $e;
        }
    }

    public function exportOrder(array $orderParameters)
    {
        try {
            $this->lastApiResponse = $this->application->exportOrder($orderParameters);
        } catch (OneStockException $e) {
            $this->lastApiException = $e;
        }
    }

    public function isLastResponseSuccessful(): bool
    {
        return is_null($this->lastApiException)
            && !is_null($this->lastApiResponse)
            && $this->lastApiResponse->isSuccess();
    }

    public function getLastErrorMessage(): string
    {
        $exception = $this->lastApiException;

        return is_null($exception)
            ? ''
            : sprintf('%s exception is thrown: %s', get_class($exception), $exception->getMessage());
    }
}
