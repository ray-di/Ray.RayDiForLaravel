<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Ray\Di\AbstractModule;

class OtherModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind(FooInterface::class)->to(FakeFoo::class);
    }
}
