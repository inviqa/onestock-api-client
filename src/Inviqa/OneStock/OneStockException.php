<?php

namespace Inviqa\OneStock;

use Exception;
use Inviqa\OneStock\Order\Exception\RequestParameterException;

class OneStockException extends Exception
{
    const PARAMETER_VALIDATION_ERROR = 32;
    const OTHER_EXCEPTION = 34;

    public static function createFromException(Exception $e)
    {
        $message = sprintf("There was an error during your OneStock request: %s", $e->getMessage());
        $code = self::OTHER_EXCEPTION;
        switch (get_class($e)) {
            case RequestParameterException::class:
                $code = self::PARAMETER_VALIDATION_ERROR;
                $message = sprintf("There is an error in the given parameters: %s", $e->getMessage());
                break;
        }

        return new self($message, $code, $e);
    }
}
