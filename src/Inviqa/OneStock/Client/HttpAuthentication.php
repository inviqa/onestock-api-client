<?php

namespace Inviqa\OneStock\Client;

class HttpAuthentication
{
    private $username;

    private $password;

    private $usernameHeader;

    private $passwordHeader;

    public function __construct(
        string $username,
        string $password,
        string $usernameHeader = 'Auth-User',
        string $passwordHeader = 'Auth-Password'
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->usernameHeader = $usernameHeader;
        $this->passwordHeader = $passwordHeader;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsernameHeader(): string
    {
        return $this->usernameHeader;
    }

    public function getPasswordHeader(): string
    {
        return $this->passwordHeader;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
