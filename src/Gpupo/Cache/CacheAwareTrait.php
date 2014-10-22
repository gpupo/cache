<?php

namespace Gpupo\Cache;

use Psr\Cache\CacheItemPoolInterface;

trait CacheAwareTrait
{
    protected $cacheItemPool;

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
