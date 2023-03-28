<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

class OverrideGreeting implements GreetingInterface
{
    public function greet(): string
    {
        return 'Hello, override!';
    }
}
