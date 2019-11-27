<?php

namespace Inviqa\OneStock\Entity;

class Regions
{
    public $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }
}
