<?php

declare(strict_types=1);

namespace App\RayDi;

use Ray\Di\AbstractModule;

class TestingModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new AppModule());
    }
}
