<?php

declare(strict_types=1);

namespace App\RayDi\Context;

use App\RayDi\ProductionModule;
use Doctrine\Common\Cache\CacheProvider;
use Ray\Compiler\AbstractInjectorContext;
use Ray\Di\AbstractModule;
use Ray\RayDiForLaravel\ApcuCacheProvider;

class ProductionContext extends AbstractInjectorContext
{
    public function __construct(string $tmpDir)
    {
        parent::__construct($this->getTmpDir($tmpDir));
    }

    public function __invoke(): AbstractModule
    {
        return new ProductionModule();
    }

    public function getCache(): CacheProvider
    {
        return new ApcuCacheProvider();
    }

    private function getTmpDir(string $tmpDir): string
    {
        $storagePath = 'storage' . DIRECTORY_SEPARATOR . 'ray-di';
        $dir = str_replace('\\', '_', self::class);

        return $tmpDir . DIRECTORY_SEPARATOR . $storagePath . DIRECTORY_SEPARATOR . $dir;
    }
}
