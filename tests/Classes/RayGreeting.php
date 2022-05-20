<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\RayDiForLaravel\Classes\Attribute\StringDecorator;

class RayGreeting implements GreetingInterface
{
    #[StringDecorator]
    public function greet(): string
    {
        return 'Hello, Ray!';
    }
}
