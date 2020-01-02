<?php

namespace Inviqa\OneStock;

interface Config
{
    public function endpoint(): string;

    public function username(): string;

    public function password(): string;

    public function siteId(): string;

    public function extraParameters(): array;
}
