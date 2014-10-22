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
    
    public function setCacheItemPool(CacheItemPoolInterface $cacheItemPool)
    {
        $this->cacheItemPool = $cacheItemPool;

        return $this;
    }
}
