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

use Gpupo\Cache\Driver\DriverInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 */
class CacheItemPool implements CacheItemPoolInterface
{
    protected $driver;

    public function getDriver()
    {
        if (!$this->driver instanceof DriverInterface) {
            throw new \InvalidArgumentException('DriverInterface missed');
        }

        return $this->driver;
    }

    protected function setDriver($driver)
    {
        if (!$driver instanceof DriverInterface) {
            $className = '\\Gpupo\\Cache\\Driver\\'
                .ucfirst(strtolower($driver)).'Driver';
            $driver = new $className();
        }

        if (!$driver instanceof DriverInterface) {
            throw new \InvalidArgumentException('$driver must implement DriverInterface');
        }

        $this->driver = $driver;
    }

    public function __construct($driver = 'Filesystem')
    {
        $this->setDriver($driver);
    }

    /**
     * @param string $key
     *
     * @return CacheItem|\Psr\Cache\CacheItemInterface
     */
    public function getItem($key)
    {
        $item = new CacheItem($key);

        $cached = $this->getDriver()->get($key);

        if ($cached) {
            $item->set($cached);
            $item->setHits(1);
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem($key)
    {
        return $this->getId($key)->exists();
    }

    /**
     * @param array $keys
     *
     * @return array|\Traversable
     */
    public function getItems(array $keys = [])
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->getItem($key);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return $this;
    }

    /**
     * Removes multiple items from the pool.
     *
     * @param array $keys
     *                    An array of keys that should be removed from the pool.
     *
     * @return static
     *                The invoked object.
     */
    public function deleteItems(array $keys)
    {
        foreach ($keys as $key) {
            $this->deleteItem($key);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteItem($key)
    {
        return $this->getDriver()->delete($key);
    }

    /**
     * Persists a cache item immediately.
     *
     * @param CacheItemInterface $item
     *                                 The cache item to save.
     *
     * @return static
     *                The invoked object.
     */
    public function save(CacheItemInterface $item)
    {
        return $this->getDriver()->save($item->getKey(), $item->get(), $item->getExpiration());
    }

    /**
     * Sets a cache item to be persisted later.
     *
     * @param CacheItemInterface $item
     *                                 The cache item to save.
     *
     * @return static
     *                The invoked object.
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        return $this;
    }

    /**
     * Persists any deferred cache items.
     *
     * @return bool
     *              TRUE if all not-yet-saved items were successfully saved. FALSE otherwise.
     */
    public function commit()
    {
        return true;
    }
}
