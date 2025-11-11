<?php

namespace App\Support;

class SocialType
{
    public string $name;
    public int $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}
