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

use Fig\Cache\BasicCacheItemTrait;
use Psr\Cache\CacheItemInterface;

/**
 * Class CacheItem
 *
 * @package Gpupo\Cache
 * @inheritdoc
 */
class CacheItem implements CacheItemInterface
{
    use BasicCacheItemTrait;

    /**
     * Default TTL 1 year in seconds - used in case no expiration was set.
     *
     * @var int
     */
    protected $ttlDefault = 31536000;

    /**
     * Bridge for backward compatibility to @see CacheItemPool returns ttl of item calculated by "expiration" on request.
     *
     * @return int TTL (expiration) of item in seconds.
     */
    public function getExpiration()
    {
        $expiration = $this->expiration;

        if (null === $expiration) {
            $expiration = $this->ttlDefault;
        } else {
            $expiration = $this->expiration->getTimestamp() - time();
        }

        return $expiration;
    }
}
