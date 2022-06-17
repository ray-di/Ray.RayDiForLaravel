<?php

declare(strict_types=1);

namespace App\RayDi\Context;

use App\RayDi\LocalModule;
use Doctrine\Common\Cache\CacheProvider;
use Ray\Compiler\AbstractInjectorContext;
use Ray\Di\AbstractModule;
use Ray\Di\NullCache;

class LocalContext extends AbstractInjectorContext
{
    public function __invoke(): AbstractModule
    {
        return new LocalModule();
    }

    public function getCache(): CacheProvider
    {
        return new NullCache();
    }
}
