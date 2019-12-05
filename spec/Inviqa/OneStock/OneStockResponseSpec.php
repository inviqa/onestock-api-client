<?php

namespace spec\Inviqa\OneStock;

use PhpSpec\ObjectBehavior;

class OneStockResponseSpec extends ObjectBehavior
{
    function it_is_successful_if_the_response_text_contains_an_order_id()
    {
        $response = json_encode(['id' => '1234']);

        $this->beConstructedWith($response);
        $this->isSuccess()->shouldBe(true);
    }

    function it_extracts_the_error_from_the_response()
    {
        $response = json_encode(
            [
                "error" => "invalid_json",
                "message" => "invalid character '\"' after object key:value pair",
            ]
        );

        $this->beConstructedWith($response);
        $this->isSuccess()->shouldBe(false);
        $this->getErrorMessage()->shouldBe("invalid character '\"' after object key:value pair");
        $this->getErrorId()->shouldBe('invalid_json');
        $this->getErrorEntityType()->shouldBe('');
        $this->getErrorEntityId()->shouldBe('');
        $this->getErrorCode()->shouldBe(400);
    }

    function it_extracts_order_duplicate_error()
    {
        $response = json_encode(
            [
                "code" => 409,
                "name" => "already_exists",
                "params" => [
                    "entity" => "order",
                    "id" => "1",
                ],
            ]
        );

        $this->beConstructedWith($response);
        $this->isSuccess()->shouldBe(false);
        $this->getErrorMessage()->shouldBe("API Error: already_exists");
        $this->getErrorId()->shouldBe('already_exists');
        $this->getErrorEntityType()->shouldBe('order');
        $this->getErrorEntityId()->shouldBe('1');
        $this->getErrorCode()->shouldBe(409);
    }
}
