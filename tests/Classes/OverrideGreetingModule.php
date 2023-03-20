<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\Di\AbstractModule;

class OverrideGreetingModule extends AbstractModule
{

    protected function configure()
    {
        $this->bind(GreetingInterface::class)->to(OverrideGreeting::class);
    }
}
