<?php

declare(strict_types=1);

namespace App\RayDi\Context;

use App\RayDi\TestingModule;
use Doctrine\Common\Cache\CacheProvider;
use Ray\Compiler\AbstractInjectorContext;
use Ray\Di\AbstractModule;
use Ray\Di\NullCache;

class TestingContext extends AbstractInjectorContext
{
    public function __invoke(): AbstractModule
    {
        return new TestingModule();
    }

    public function getCache(): CacheProvider
    {
        return new NullCache();
    }
}
