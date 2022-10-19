<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel\Classes;

use Doctrine\Common\Cache\CacheProvider;
use Ray\Compiler\AbstractInjectorContext;
use Ray\Compiler\DiCompileModule;
use Ray\Di\AbstractModule;
use Ray\RayDiForLaravel\ApcuCacheProvider;

class FakeCacheableContext extends AbstractInjectorContext
{
    public function __construct(string $tmpDir)
    {
        $dir = str_replace('\\', '_', self::class);
        parent::__construct($tmpDir . '/tmp/' . $dir);
    }

    public function __invoke(): AbstractModule
    {
        $module = new Module();
        $module->install(new DiCompileModule(true));
        $module->override(new class extends AbstractModule {
            protected function configure()
            {
                $this->bind(FakeInterface::class)->toNull();
                $this->bind(InjectableService::class);
            }
        });

        return $module;
    }

    public function getSavedSingleton(): array
    {
        return [GreetingInterface::class];
    }

    public function getCache(): CacheProvider
    {
        return new ApcuCacheProvider();
    }
}
