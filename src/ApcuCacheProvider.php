<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Symfony\Component\Cache\Adapter\ApcuAdapter;

class ApcuCacheProvider
{
    public static function create(string $namespace): CacheProvider
    {
        $cache = DoctrineProvider::wrap(new ApcuAdapter($namespace));
        assert($cache instanceof CacheProvider);

        return $cache;
    }
}
