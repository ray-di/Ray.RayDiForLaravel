<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\RayDiForLaravel\Attribute\Injectable;

#[Injectable]
final class InjectableService
{
    public function __construct(private GreetingInterface $greeting)
    {
    }

    public function run(): string
    {
        return $this->greeting->greet();
    }
}
