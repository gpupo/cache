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

interface DriverInterface
{
    public function save($id, $obj, $ttl, $serialize = true);
    public function get($id, $unserialize = true);
    public function delete($id);
    public function isSupported();
}
