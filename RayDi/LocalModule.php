<?php

declare(strict_types=1);

namespace App\RayDi;

use Ray\Di\AbstractModule;

class LocalModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new AppModule());
    }
}
