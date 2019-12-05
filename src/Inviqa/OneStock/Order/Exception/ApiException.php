<?php

namespace Inviqa\OneStock\Order\Exception;

use Exception;
use Inviqa\OneStock\OneStockResponse;

class ApiException extends Exception
{
    public static function createFromJsonResponse(OneStockResponse $response)
    {
        $message = $response->getErrorMessage();

        switch ($response->getErrorId()) {
            case "already_exists":

                $message = sprintf(
                    "The %s with the ID %s you are trying to create already exists.",
                    $response->getErrorEntityType(),
                    $response->getErrorEntityId()
                );

                break;
        }

        return new self($message, $response->getErrorCode());
    }
}
