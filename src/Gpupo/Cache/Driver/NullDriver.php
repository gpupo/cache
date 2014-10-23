<?php

namespace Gpupo\Cache\Driver;

class NullDriver extends DriverAbstract implements DriverInterface
{
    public function save($id, $obj, $ttl, $serialize = true)
    {
        return true;
    }

    public function get($id, $unserialize = true)
    {
        return false;
    }

    public function delete($id)
    {
        return true;
    }

    public function isSupported()
    {
        return true;
    }
}
