<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

final class NonInjectableService
{
    public function __construct(private GreetingInterface $greeting)
    {
    }

    public function run(): string
    {
        return $this->greeting->greet();
    }
}
