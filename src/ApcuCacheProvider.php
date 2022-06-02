<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel;

use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\CacheProvider;

class ApcuCacheProvider
{
    public static function create(): CacheProvider
    {
        return new ApcuCache();
    }
}
