<?php

namespace Ray\RayDiForLaravel\Classes;

final class IlluminateGreeting implements GreetingInterface
{
    public function greet(): string
    {
        return 'Hello, Illuminate!';
    }
}
