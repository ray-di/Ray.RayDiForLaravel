<?php

namespace Ray\RayDiForLaravel\Classes;

final class NonInjectableService
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
