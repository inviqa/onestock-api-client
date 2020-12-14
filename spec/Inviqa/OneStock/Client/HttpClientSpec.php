<?php

namespace spec\Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Inviqa\OneStock\Client\HttpAuthentication;
use Inviqa\OneStock\Client\HttpClient;
use Inviqa\OneStock\Entity\Address;
use Inviqa\OneStock\Entity\Country;
use Inviqa\OneStock\Entity\Customer;
use Inviqa\OneStock\Entity\Delivery;
use Inviqa\OneStock\Entity\Destination;
use Inviqa\OneStock\Entity\ItemDelivery;
use Inviqa\OneStock\Entity\ItemPayment;
use Inviqa\OneStock\Entity\LineItem;
use Inviqa\OneStock\Entity\Order;
use Inviqa\OneStock\Entity\Payment;
use Inviqa\OneStock\Entity\Regions;
use Inviqa\OneStock\Entity\ShippingCarrier;
use Inviqa\OneStock\Entity\UpdatedLineItem;
use Inviqa\OneStock\Factory\SerializerFactory;
use Inviqa\OneStock\LineUpdater\LineItemUpdateRequest;
use Inviqa\OneStock\Order\Request\JsonRequest;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Serializer\SerializerInterface;

class HttpClientSpec extends ObjectBehavior
{
    function let(ClientInterface $client, Response $response)
    {
        $this->beConstructedWith(
            $client,
            new HttpAuthentication('user', 'password'),
            (new SerializerFactory())->createSerializer()
        );

        $client->send(Argument::cetera())->willReturn($response);
    }

    function it_does_not_encode_empty_arguments(ClientInterface $client, SerializerInterface $serializer)
    {
        $requestParams = new LineItemUpdateRequest(
            '1234',
            [
                ['id' => 1, 'payment' => ['price' => 9.99], 'from' => 'start', 'to' => 'finish'],
            ]
        );

        $this->request('POST', '/foo', $requestParams);

        $hasEmpty = [$this, 'hasEmpty'];
        $client->send(Argument::that(function(Request $request) use ($hasEmpty) {
                return $hasEmpty(json_decode($request->getBody()->getContents(), true));
            }))
            ->shouldHaveBeenCalled();
    }

    function it_does_not_encode_empty_arguments_when_creating_order(ClientInterface $client)
    {
        $customer = new Customer('Mr', 'John', 'Doe', '+1234567890', 'john@server.com');
        $address = new Address(
            ['Foo Bar street 5.'],
            'Baz city',
            'abc123',
            new Regions(new Country('GB')),
            $customer
        );
        $request = new JsonRequest(
            '1234',
            new Order(
                '5678',
                [],
                '1',
                'ecommerce',
                new Delivery(new Destination($address, 'c123')),
                new Payment('EUR', 9.99, 5, 'EUR', $address),
                $customer,
                [
                    new LineItem(
                        '1',
                        '1',
                        new ItemPayment(4.99),
                        new ItemDelivery('CODE123', new ShippingCarrier('ACME Ltd.', ''))
                    )
                ]
            )
        );

        $this->createOrder($request);

        $hasEmpty = [$this, 'hasEmpty'];
        $client->send(Argument::that(function(Request $request) use ($hasEmpty) {
                return $hasEmpty(json_decode($request->getBody()->getContents(), true));
            }))
            ->shouldHaveBeenCalled();
    }

    private function hasEmpty(array $data): bool
    {
        $empty = true;
        foreach ($data as $value) {
            if (null === $value || [] === $value) {
                return false;
            }

            if (is_array($value)) {
                $empty = $empty && $this->hasEmpty($value);
            }
        }

        return $empty;
    }
}
