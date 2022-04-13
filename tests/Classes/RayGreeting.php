<?php

namespace Ray\RayDiForLaravel\Classes;

final class RayGreeting implements GreetingInterface
{
    public function greet(): string
    {
        return 'Hello, Ray!';
    }
}
