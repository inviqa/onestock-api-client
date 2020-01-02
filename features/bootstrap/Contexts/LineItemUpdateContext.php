<?php

namespace Contexts;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Services\TestApplicationProxy;
use Services\TestConfig;
use Webmozart\Assert\Assert;

class LineItemUpdateContext implements Context
{
    private $lineItemUpdateParameters = [];

    private $testApplicationProxy;

    public function __construct(string $cassettePath)
    {
        $this->testApplicationProxy = new TestApplicationProxy(new TestConfig($cassettePath));
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
        $this->testApplicationProxy->updateLineItems($this->lineItemUpdateParameters);
    }

    /**
     * @Then they should be successful
     */
    public function itShouldBeSuccessful()
    {
        Assert::true($this->testApplicationProxy->isLastResponseSuccessful(), $this->testApplicationProxy->getLastErrorMessage());
    }
}
