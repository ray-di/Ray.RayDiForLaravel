<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\RayDiForLaravel\Attribute\Injectable;

#[Injectable]
final class InjectableService
{
    public function __construct(private GreetingInterface $greeting, private FakeInterface $fake)
    {
    }

    public function run(): string
    {
        ($this->fake)();

        return $this->greeting->greet();
    }
}
