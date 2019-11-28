<?php

namespace Inviqa\OneStock\Entity;

class Customer
{
    public $title = '';

    public $first_name = '';

    public $last_name = '';

    public $phone_number = '';

    public $email = '';

    public function __construct(
        string $title,
        string $first_name,
        string $last_name,
        string $phone_number,
        string $email
    ) {
        $this->title = $title;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone_number = $phone_number;
        $this->email = $email;
    }
}
