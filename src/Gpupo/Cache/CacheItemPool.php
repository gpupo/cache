<?php

namespace Gpupo\Cache;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 */
class CacheItemPool implements CacheItemPoolInterface
{
    protected $driver;

    public function getDriver(){
        return $this->driver;
    }

    protected function setDriver($driver)
    {
        if (!$driver instanceof \Gpupo\Cache\Driver\DriverInterface) {
            $className = '\\Gpupo\\Cache\\Driver\\' 
                . ucfirst(strtolower($driver)) . 'Driver';
            $driver = new $className;
        }
        
        $this->driver = $driver;
    }

    public function __construct($driver = 'Apc')
    {
        $this->setDriver($driver);
    }

    /**
     * @param  string                                    $key
     * @return CacheItem|\Psr\Cache\CacheItemInterface
     */
    public function getItem($key)
    {
        $item = new CacheItem($key);

        $cached = $this->getDriver()->get($key);

        if ($cached) {
            $item->set($cached);
        }

        return $item;
    }

    /**
     * @param  array              $keys
     * @return array|\Traversable
     */
    public function getItems(array $keys = array())
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->getItem($key);
        }

        return $result;
    }

    /**
     * @return $this|CacheItemPoolInterface
     */
    public function clear()
    {
        return $this;
    }

    /**
     * Removes multiple items from the pool.
     *
     * @param  array  $keys
     *                      An array of keys that should be removed from the pool.
     * @return static
     *                     The invoked object.
     */
    public function deleteItems(array $keys)
    {
        return $this;
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
     * @param  CacheItemInterface $item
     *                                  The cache item to save.
     * @return static
     *                                 The invoked object.
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
