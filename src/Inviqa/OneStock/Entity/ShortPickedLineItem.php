<?php

namespace Inviqa\OneStock\Entity;

use DateTimeImmutable;
use UnexpectedValueException;

class ShortPickedLineItem
{
    public $date;

    public $id;

    public $item_id;

    public $state;

    public $origin;

    public function __construct(int $date, string $id, string $item_id, string $state, string $origin)
    {
        $this->setDate($date);
        $this->id = $id;
        $this->item_id = $item_id;
        $this->state = $state;
        $this->origin = $origin;
    }

    private function setDate(int $date): void
    {
        if (DateTimeImmutable::createFromFormat('U', (string) $date) === false) {
            throw new UnexpectedValueException(sprintf('Date parameter must be a valid timestamp, but got "%s".', $date));
        }

        $this->date = $date;
    }
}
