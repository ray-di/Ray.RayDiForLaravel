<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Doctrine\Common\Cache\CacheProvider;
use Ray\Compiler\AbstractInjectorContext;
use Ray\Di\AbstractModule;
use Ray\Di\NullCache;

class FakeContext extends AbstractInjectorContext
{
    public function __construct(string $tmpDir)
    {
        $dir = str_replace('\\', '_', self::class);
        parent::__construct($tmpDir . '/tmp/' . $dir);
    }

    public function getModule(): AbstractModule
    {
        return new Module();
    }

    public function getSavedSingleton(): array
    {
        return [];
    }

    public function getCache(): CacheProvider
    {
        return new NullCache();
    }
}
