<?php

/*
 * This file is part of gpupo/cache
 * Created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file
 * LICENSE which is distributed with this source code.
 * Para a informação dos direitos autorais e de licença você deve ler o arquivo
 * LICENSE que é distribuído com este código-fonte.
 * Para obtener la información de los derechos de autor y la licencia debe leer
 * el archivo LICENSE que se distribuye con el código fuente.
 * For more information, see <https://www.gpupo.com/>.
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
