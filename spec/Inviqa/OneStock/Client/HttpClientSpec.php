<?php

namespace spec\Inviqa\OneStock\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Inviqa\OneStock\Client\HttpClient;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpClientSpec extends ObjectBehavior
{
    function let(ClientInterface $client, Response $response)
    {
        $this->beConstructedWith($client, ['username' => 'user', 'password' => 'password']);

        $client->send(Argument::cetera())->willReturn($response);
    }

    function it_does_not_encode_empty_arguments(ClientInterface $client)
    {
        $requestParams = [
            'first' => 123,
            'second' => [],
            'third' => 'bar',
            'fourth' => null,
            'fifth' => [
                'embedded' => null,
            ],
            'sixth' => (object) [
                'embedded' => null
            ],
            'seventh' => (object) [
                'embedded' => 'baz',
            ]
        ];

        $this->request('POST', '/foo', (object) $requestParams);

        $client->send(Argument::that(function(Request $request) {
                return $request->getBody()->getContents() === '{"first":123,"third":"bar","seventh":{"embedded":"baz"}}';
            }))
            ->shouldHaveBeenCalled();
    }
}
