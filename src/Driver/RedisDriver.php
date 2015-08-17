<?php

namespace Gpupo\Cache\Driver;

use Predis\Client;

class RedisDriver implements DriverInterface
{
    private $redisClient;

    public function __construct(Client $redisClient)
    {
        $this->redisClient = $redisClient;
    }

    public function save($id, $obj, $ttl, $serialize = true)
    {
        if ($serialize) {
            $obj = serialize($obj);
        }
        return $this->redisClient->set($id, $obj, "ex", $ttl);
    }

    public function get($id, $unserialize = true)
    {
        $value = $this->redisClient->get($id);
        if ($value === null) {
            return null;
        }
        if ($unserialize) {
            return unserialize($value);
        }
        return $value;
    }

    public function delete($id)
    {
        $this->redisClient->del($id);
    }

    public function isSupported()
    {
        return class_exists("Predis\Client");
    }
}
