<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\Di\AbstractModule;

class FakeInvalidBindModule extends AbstractModule
{

    protected function configure()
    {
        $this->bind(InjectableService::class);
    }
}
