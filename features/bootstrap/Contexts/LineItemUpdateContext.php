<?php

namespace Contexts;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Exception;
use Inviqa\OneStock\Application;
use Inviqa\OneStock\OneStockException;
use Services\HttpMock;
use Services\TestConfig;
use Webmozart\Assert\Assert;

class LineItemUpdateContext implements Context
{
    private $lineItemUpdateParameters = [];

    /**
     * @var Application
     */
    private $application;

    /**
     * @var \Inviqa\OneStock\OneStockResponse|null
     */
    private $lastApiResponse;

    /**
     * @var Exception|OneStockException|null
     */
    private $lastApiException;

    public function __construct(string $cassettePath)
    {
        $this->application = new Application(new TestConfig(), new HttpMock($cassettePath));
    }

    /**
     * @Given the following line items is changed:
     */
    public function theFollowingLineItemsIsChanged(PyStringNode $string)
    {
        $this->lineItemUpdateParameters[] = json_decode($string->getRaw(), true);
    }

    /**
     * @When line items updates are exported
     */
    public function lineItemsUpdatesAreExported()
    {
        try {
            $this->lastApiResponse = $this->application->updateLineItems($this->lineItemUpdateParameters);
        } catch (OneStockException $e) {
            $this->lastApiException = $e;
        }
    }

    /**
     * @Then it should be successful
     */
    public function itShouldBeSuccessful()
    {
        if (!is_null($this->lastApiResponse)) {
            Assert::true(
                $this->lastApiResponse->isSuccess(),
                'Error in API response: '.$this->lastApiResponse->getErrorMessage()
            );
        }

        if (!$this->lastApiException instanceof Exception) {
            return;
        }

        Assert::null(
            $this->lastApiException,
            sprintf(
                '%s exception is thrown: %s',
                get_class($this->lastApiException),
                $this->lastApiException->getMessage()
            )
        );
    }
}
