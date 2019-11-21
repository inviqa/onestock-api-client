<?php

namespace Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class OrderExportContext implements Context
{
    /**
     * @Given the following order has been placed
     */
    public function theFollowingOrderHasBeenPlaced(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given order with id :arg1 contains the following line items
     */
    public function orderWithIdContainsTheFollowingLineItems($arg1, TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @When order :arg1 is exported
     */
    public function orderIsExported($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then the export for order :arg1 should be successful
     */
    public function theExportForOrderShouldBeSuccessful($arg1)
    {
        throw new PendingException();
    }


}
