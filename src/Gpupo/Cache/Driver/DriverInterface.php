<?php

namespace Gpupo\Cache\Driver;

interface DriverInterface
{
    public function save($id, $obj, $ttl, $serialize = true);
    public function get($id, $unserialize = true);
    public function delete($id);
    public function isSupported();
}
