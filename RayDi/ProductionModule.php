<?php

declare(strict_types=1);

namespace App\RayDi;

use Ray\Compiler\DiCompileModule;
use Ray\Di\AbstractModule;

class ProductionModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new AppModule());
        $this->install(new DiCompileModule(true)); // to use CompileInjector
    }
}
