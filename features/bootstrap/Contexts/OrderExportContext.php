<?php

namespace Contexts;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\OneStock\Application;
use Services\TestConfig;
use Webmozart\Assert\Assert;

class OrderExportContext implements Context
{
    private $application;

    private $orders;

    private $response;

    public function __construct()
    {
        $config = new TestConfig();
        $this->application = new Application($config);
    }

    /**
     * @Given the following order has been placed
     */
    public function theFollowingOrderHasBeenPlaced(TableNode $table)
    {
        foreach ($table->getColumnsHash() as $order) {
            $this->orders[$order['id']] = $order;
        }
    }

    /**
     * @Given order with id :orderId contains the following line items
     */
    public function orderWithIdContainsTheFollowingLineItems(string $orderId, TableNode $table)
    {
        if (!isset($this->orders[$orderId])) {
            throw new \InvalidArgumentException(sprintf('The order %s cannot be found', $orderId));
        }

        $this->orders[$orderId]['line_items'] = $table->getColumnsHash();
    }


    /**
     * @Given order with id :orderId is delivered to the following address
     */
    public function orderWithIdIsDeliveredToTheFollowingAddress(string $orderId, TableNode $table)
    {
        $this->orders[$orderId]['shipping_address'] = $table->getColumnsHash()[0];
    }

    /**
     * @Given the order :orderId has the following payment
     */
    public function theOrderHasTheFollowingPayment(string $orderId, TableNode $table)
    {
        $this->orders[$orderId]['payment'] = $table->getColumnsHash()[0];
    }

    /**
     * @Given order with id :orderId has the following billing address
     */
    public function orderWithIdHasTheFollowingBillingAddress(string $orderId, TableNode $table)
    {
        $this->orders[$orderId]['billing_address'] = $table->getColumnsHash()[0];
    }

    /**
     * @When order :orderId is exported
     */
    public function orderIsExported(string $orderId)
    {
        $this->response = $this->application->exportOrder($this->orders[$orderId]);
    }
    /**
     * @Then the export for order :orderId should be successful
     */
    public function theExportForOrderShouldBeSuccessful(string $orderId)
    {
        Assert::notNull($this->response);
        Assert::true($this->response->isSuccess());
    }


}
