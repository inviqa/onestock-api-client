<?php

namespace Inviqa\OneStock\Entity;

use DateTime;
use Exception;
use UnexpectedValueException;

class ShortPickedLineItem
{
    public $date;

    public $id;

    public $item_id;

    public $state;

    public function __construct(int $date, string $id, string $item_id, string $state)
    {
        $this->setDate($date);
        $this->id = $id;
        $this->item_id = $item_id;
        $this->state = $state;
    }

    private function setDate(int $date): void
    {
        try {
            new DateTime('@' . $date);
        } catch (Exception $e) {
            throw new UnexpectedValueException(sprintf('Date parameter must be a valid timestamp, but got "%s".', $date));
        }

        $this->date = $date;
    }
}
