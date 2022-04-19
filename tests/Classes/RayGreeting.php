<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

final class RayGreeting implements GreetingInterface
{
    public function greet(): string
    {
        return 'Hello, Ray!';
    }
}
