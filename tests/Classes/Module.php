<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\Di\AbstractModule;
use Ray\Di\Scope;
use Ray\RayDiForLaravel\Classes\Attribute\StringDecorator;

final class Module extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(GreetingInterface::class)->to(RayGreeting::class)->in(Scope::SINGLETON);
        $this->bind(FakeInterface::class)->to(Fake::class);
        $this->bind(FooInterface::class)->to(Foo::class);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(StringDecorator::class),
            [FakeInterceptor::class]
        );
    }
}
