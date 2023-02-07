<?php

declare(strict_types=1);

namespace Ray\RayDiForLaravel;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\CacheProvider;

class ApcuCacheProvider extends CacheProvider
{
    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        return apcu_fetch($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return apcu_exists($id); // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        return apcu_store($id, $data, $lifeTime);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDelete($id)
    {
        // apcu_delete returns false if the id does not exist
        return apcu_delete($id) || ! apcu_exists($id); // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     */
    protected function doDeleteMultiple(array $keys)
    {
        $result = apcu_delete($keys); // @codeCoverageIgnoreStart

        return $result !== false && count($result) !== count($keys); // @codeCoverageIgnoreEnd
    }

    /**
     * {@inheritdoc}
     */
    protected function doFlush()
    {
        return apcu_clear_cache(); // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetchMultiple(array $keys)
    {
        return apcu_fetch($keys) ?: []; // @codeCoverageIgnore
    }

    /**
     * {@inheritdoc}
     */
    protected function doSaveMultiple(array $keysAndValues, $lifetime = 0)
    {
        $result = apcu_store($keysAndValues, null, $lifetime); // @codeCoverageIgnoreStart

        return empty($result); // @codeCoverageIgnoreEnd
    }

    /**
     * {@inheritdoc}
     */
    protected function doGetStats()
    {
        $info = apcu_cache_info(true); // @codeCoverageIgnoreStart
        $sma  = apcu_sma_info();

        return [
            Cache::STATS_HITS             => $info['num_hits'],
            Cache::STATS_MISSES           => $info['num_misses'],
            Cache::STATS_UPTIME           => $info['start_time'],
            Cache::STATS_MEMORY_USAGE     => $info['mem_size'],
            Cache::STATS_MEMORY_AVAILABLE => $sma['avail_mem'],
        ]; // @codeCoverageIgnoreEnd
    }
}
