<?php

namespace Contexts;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Inviqa\OneStock\Application;
use Inviqa\OneStock\Client\FakeClient;
use Inviqa\OneStock\OneStockException;
use Services\TestConfig;
use Webmozart\Assert\Assert;

class OrderExportContext implements Context
{
    private $application;

    private $orders;

    private $response;

    private $exception;

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
        $this->orders[$orderId] += $table->getColumnsHash()[0];
    }

    /**
     * @Given the order :orderId has the following payment
     */
    public function theOrderHasTheFollowingPayment(string $orderId, TableNode $table)
    {
        $this->orders[$orderId] += $table->getColumnsHash()[0];
    }

    /**
     * @Given order with id :orderId has the following billing address
     */
    public function orderWithIdHasTheFollowingBillingAddress(string $orderId, TableNode $table)
    {
        $this->orders[$orderId] += $table->getColumnsHash()[0];
    }

    /**
     * @Given the order :orderId does not have payment data
     */
    public function theOrderDoesNotHavePaymentData($orderId)
    {
        unset($this->orders[$orderId]['price']);
        unset($this->orders[$orderId]['currency']);
        unset($this->orders[$orderId]['shipping_amount']);
    }

    /**
     * @Given the order :orderId already exists in OneStockApi
     */
    public function theOrderAlreadyExistsInOneStockApi($orderId)
    {
        $this->orders[$orderId]['last_name'] = FakeClient::ORDER_ALREADY_EXISTS_SCENARIO;
    }

    /**
     * @Then /^I should get an error with the content:$/
     */
    public function iShouldGetAnErrorWithTheContent(PyStringNode $string)
    {
        Assert::notNull($this->exception);
        Assert::eq($this->exception->getMessage(), $string->getRaw());
    }

    /**
     * @Then I should get a :exceptionClass exception with the error
     */
    public function iShouldGetAWithTheError($exceptionClass)
    {
        Assert::notNull($this->exception);
        Assert::subclassOf($this->exception, OneStockException::class);
    }

    /**
     * @When order :orderId is exported
     */
    public function orderIsExported(string $orderId)
    {
        try {
            $this->response = $this->application->exportOrder($this->orders[$orderId]);
        } catch (OneStockException $e) {
            $this->exception = $e;
        }
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
