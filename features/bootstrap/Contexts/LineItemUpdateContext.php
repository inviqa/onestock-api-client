<?php

namespace Contexts;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Services\Api;
use Webmozart\Assert\Assert;

class LineItemUpdateContext implements Context
{
    private $lineItemUpdateParameters = [];

    /**
     * @var Api
     */
    private $api;

    public function __construct(string $cassettePath)
    {
        $this->api = new Api($cassettePath);
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
        $this->api->updateLineItems($this->lineItemUpdateParameters);
    }

    /**
     * @Then it should be successful
     */
    public function itShouldBeSuccessful()
    {
        Assert::true($this->api->isLastResponseSuccessful(), $this->api->getLastErrorMessage());
    }
}
