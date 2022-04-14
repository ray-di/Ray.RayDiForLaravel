<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\Di\AbstractModule;

final class Module extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(GreetingInterface::class)->to(RayGreeting::class);
    }
}
