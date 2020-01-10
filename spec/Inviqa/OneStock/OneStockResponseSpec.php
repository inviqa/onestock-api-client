<?php

namespace spec\Inviqa\OneStock;

use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class OneStockResponseSpec extends ObjectBehavior
{
    function let(RequestInterface $request, ResponseInterface $response, StreamInterface $body)
    {
        $response->getBody()->willReturn($body);
        $this->beConstructedWith($request, $response);
    }

    function it_is_successful_if_the_response_code_starts_with_two(ResponseInterface $response)
    {

        $response->getStatusCode()->willReturn(201);
        $this->isSuccess()->shouldBe(true);
    }

    function it_extracts_the_error_from_the_response(ResponseInterface $response, StreamInterface $body)
    {
        $response->getStatusCode()->willReturn(400);
        $body->__toString()->willReturn(json_encode(
            [
                "error" => "invalid_json",
                "message" => "invalid character '\"' after object key:value pair",
            ]
        ));

        $this->isSuccess()->shouldBe(false);
        $this->getErrorMessage()->shouldBe("invalid character '\"' after object key:value pair");
        $this->getErrorId()->shouldBe('invalid_json');
        $this->getErrorEntityType()->shouldBe('');
        $this->getErrorEntityId()->shouldBe('');
        $this->getErrorCode()->shouldBe(400);
    }

    function it_extracts_order_duplicate_error(ResponseInterface $response, StreamInterface $body)
    {
        $response->getStatusCode()->willReturn(409);
        $body->__toString()->willReturn(json_encode([
            "code" => 409,
            "name" => "already_exists",
            "params" => [
                "entity" => "order",
                "id" => "1",
            ],
        ]));

        $this->isSuccess()->shouldBe(false);
        $this->getErrorMessage()->shouldBe("API Error: already_exists");
        $this->getErrorId()->shouldBe('already_exists');
        $this->getErrorEntityType()->shouldBe('order');
        $this->getErrorEntityId()->shouldBe('1');
        $this->getErrorCode()->shouldBe(409);
    }

    function it_is_not_successful_when_response_body_contains_error_code(
        ResponseInterface $response, StreamInterface $body
    ) {
        $response->getStatusCode()->willReturn(200);
        $body->__toString()->willReturn(json_encode([
            [
                "code" => 400,
                "error" => "invalid id: expected a string",
            ]
        ]));

        $this->isSuccess()->shouldReturn(false);
    }
}
