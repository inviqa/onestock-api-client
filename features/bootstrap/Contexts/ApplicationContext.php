<?php

namespace Contexts;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use RuntimeException;
use Services\TestApplicationProxy;
use Services\TestConfig;
use Webmozart\Assert\Assert;

class ApplicationContext implements Context
{
    private $testApplicationProxy;

    public function __construct(string $cassettePath)
    {
        $this->testApplicationProxy = new TestApplicationProxy(new TestConfig($cassettePath));
    }

    /**
     * @Given I send the following line item update:
     */
    public function theFollowingLineItemsIsChanged(PyStringNode $string)
    {
        $this->testApplicationProxy->updateLineItems($this->decodeJson($string));
    }

    /**
     * @When I create the following parcel:
     */
    public function iCreateTheFollowingParcel(PyStringNode $string)
    {
        $this->testApplicationProxy->createParcel(json_decode($string->getRaw(), true));
    }

    /**
     * @Then the api should return a successful response
     */
    public function itShouldBeSuccessful()
    {
        Assert::true(
            $this->testApplicationProxy->isLastResponseSuccessful(),
            $this->testApplicationProxy->getLastResponse()->getErrorMessage()
        );
    }

    private function decodeJson(PyStringNode $string)
    {
        $decoded = json_decode($string->getRaw(), true);
        if (null === $decoded) {
            throw new RuntimeException(sprintf(
                'Could not decode JSON "%s": %s',
                $string->getRaw(),
                json_last_error_msg()
            ));
        }
        return $decoded;
    }
}
