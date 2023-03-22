<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\RayDiForLaravel\Attribute\Injectable;

#[Injectable]
final class InjectableService
{
    public function __construct(private GreetingInterface $greeting, private FakeInterface $fake, private FooInterface $foo)
    {
    }

    public function run(): string
    {
        ($this->fake)();
        $value = ($this->foo)();

        return $this->greeting->greet() . $value;
    }
}
