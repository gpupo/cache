<?php

/*
 * This file is part of gpupo\cache
 *
 * (c) Gilmar Pupo <g@g1mr.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
