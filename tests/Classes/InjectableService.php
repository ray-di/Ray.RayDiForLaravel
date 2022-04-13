<?php

namespace Ray\RayDiForLaravel\Classes;

use Ray\RayDiForLaravel\Attribute\Injectable;

#[Injectable]
final class InjectableService
{
    private GreetingInterface $greeting;

    public function __construct(GreetingInterface $greeting)
    {
        $this->greeting = $greeting;
    }

    public function run(): string
    {
        return $this->greeting->greet();
    }
}
