<?php

/*
 * This file is part of gpupo\cache
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gpupo\Cache;

use Psr\Cache\CacheItemPoolInterface;

trait CacheAwareTrait
{
    protected $cacheItemPool;

    /**
     * Returns an instance of CacheItemPool.
     *
     * @return CacheItemPoolInterface|null The CacheItemPool instance if set, otherwise NULL
     */
    public function getCacheItemPool()
    {
        return $this->cacheItemPool;
    }

    public function hasCacheItemPool()
    {
        return !empty($this->cacheItemPool);
    }

    public function setCacheItemPool(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;

        return $this;
    }

    protected function factoryCacheKey($key, $prefix = null)
    {
        return $this->getCacheItemPool()->getDriver()->generateId($key, $prefix);
    }
}
