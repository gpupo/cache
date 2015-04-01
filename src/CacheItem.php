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

use Psr\Cache\CacheItemInterface;

class CacheItem implements CacheItemInterface
{
    private $key;

    private $ttl = 60;

    private $value;

    private $hits = 0;

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return \Serializable|mixed
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @param \Serializable $value
     * @param int           $ttl
     * @returns boolean
     */
    public function set($value = null, $ttl = null)
    {
        $this->value = $value;
        $this->setExpiration($ttl);

        return true;
    }

    public function setHits($value)
    {
        $this->hits = intval($value);
    }

    public function getHits()
    {
        return $this->hits;
    }
    /**
     * @return bool
     */
    public function isHit()
    {
        return ($this->getHits() > 0);
    }

    /**
     * Removes the current key from the cache.
     *
     * @return \Psr\Cache\CacheItemInterface
     *                                       The current item.
     */
    public function delete()
    {
        $this->set(null);

        return $this;
    }

    /**
     * nope doesnt exist. ever.
     *
     * @return bool
     */
    public function exists()
    {
        return !empty($this->value);
    }

    /**
     * This method is used to tell future calls to this item if re-regeneration of
     * this item's data is in progress or not.
     *
     * This can be used to prevent the dogpile effect to stop lots of requests re-generating
     * the fresh data over and over.
     *
     * @return bool
     */
    public function isRegenerating()
    {
        return false;
    }

    /**
     * Sets the expiration for this cache item.
     *
     * @param int|\DateTime $ttl
     *                           - If an integer is passed, it is interpreted as the number of seconds
     *                           after which the item MUST be considered expired.
     *                           - If a DateTime object is passed, it is interpreted as the point in
     *                           time after which the item MUST be considered expired.
     *                           - If null is passed, a default value MAY be used. If none is set,
     *                           the value should be stored permanently or for as long as the
     *                           implementation allows.
     *
     * @return static The called object.
     */
    public function setExpiration($ttl = null)
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function getExpiration()
    {
        return $this->ttl;
    }
}
