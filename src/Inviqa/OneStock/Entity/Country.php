<?php

namespace Inviqa\OneStock\Entity;

class Country
{
    public $code = '';

    public function __construct(string $code)
    {
        $this->code = $code;
    }
}
