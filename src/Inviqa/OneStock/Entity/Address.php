<?php

namespace Inviqa\OneStock\Entity;

class Address
{
    public $lines = [];

    public $city = '';

    public $zip_code = '';

    public $regions;

    public $contact;

    public function __construct(array $lines, string $city, string $zip_code, Regions $regions, Customer $contact)
    {
        $this->lines = $lines;
        $this->city = $city;
        $this->zip_code = $zip_code;
        $this->regions = $regions;
        $this->contact = $contact;
    }
}
