<?php

namespace Contexts;

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use RuntimeException;
use Services\TestApplicationProxy;
use Services\TestConfig;
use Services\TraceableHttpClient;
use Webmozart\Assert\Assert;
use Behat\Gherkin\Node\TableNode;

class ApplicationContext implements Context
{

    /**
     * @var TestApplicationProxy
     */
    private $testApplicationProxy;

    /**
     * @var TraceableHttpClient
     */
    private $tracebleHttpClient;

    /**
     * @var TestConfig
     */
    private $config;

    public function __construct(string $cassettePath)
    {
        $this->config = new TestConfig($cassettePath);

        $this->tracebleHttpClient = new TraceableHttpClient(new Client([
            'base_uri' => $this->config->endpoint(),
            RequestOptions::HTTP_ERRORS => false,
        ]));
    }

    /**
     * @Given I send the following line item update:
     */
    public function theFollowingLineItemsIsChanged(PyStringNode $string)
    {
        $this->applicationProxy()->updateLineItems($this->decodeJson($string->getRaw()));
    }

    /**
     * @Given the following extra parameters configured:
     */
    public function theFollowingExtraParametersConfigured(TableNode $table)
    {
        foreach ($table->getRowsHash() as $parameterName => $parameterValue) {
            $this->config->addExtraParameter($parameterName, $parameterValue);
        }
    }

    /**
     * @When I send the following short picked items:
     */
    public function theFollowingShortPickedItems(PyStringNode $string)
    {
        $this->applicationProxy()->shortPickItems($this->decodeJson($string->getRaw()));
    }

    /**
     * @When I create the following parcel:
     */
    public function iCreateTheFollowingParcel(PyStringNode $string)
    {
        $this->applicationProxy()->createParcel($this->decodeJson($string->getRaw(), true));
    }

    /**
     * @Then the api should return a successful response
     */
    public function itShouldBeSuccessful()
    {
        Assert::true(
            $this->applicationProxy()->isLastResponseSuccessful(),
            $this->applicationProxy()->getLastResponse()->getErrorMessage()
        );
    }

    /**
     * @Then the following request should be sent to Onestock:
     */
    public function theFollowingRequestShouldBeSentToOneStock(PyStringNode $node)
    {
        Assert::eq($this->decodeJson(
            $this->applicationProxy()->getLastResponse()->request()->getBody()->__toString()
        ), $this->decodeJson($node->getRaw()));
    }

    /**
     * @Then the API request should have the headers set:
     */
    public function theApiRequestShouldHaveTheHeadersSet(TableNode $table)
    {
        $headerNames = array_keys($this->tracebleHttpClient->getLastRequest()->getHeaders());
        foreach ($table ->getRowsHash() as $headerName) {
            Assert::inArray(
                $headerName,
                $headerNames,
                sprintf('Expected to have a HTTP header "%s".', $headerName)
            );
        }
    }

    private function decodeJson(string $json)
    {
        $decoded = json_decode($json, true);
        if (null === $decoded) {
            throw new RuntimeException(sprintf(
                'Could not decode JSON "%s": %s',
                $json,
                json_last_error_msg()
            ));
        }
        return $decoded;

    }

    private function applicationProxy(): TestApplicationProxy
    {
        if (null === $this->testApplicationProxy) {
            $this->testApplicationProxy = new TestApplicationProxy($this->config, $this->tracebleHttpClient);
        }

        return $this->testApplicationProxy;
    }

}
