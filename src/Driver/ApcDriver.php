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

/**
 * Driver de conexao do PHP com a memoria, utilizando APC.
 */
class ApcDriver extends DriverAbstract implements DriverInterface
{
    /**
     * @param string $id
     * @param mixed  $obj
     * @param int    $ttl
     *
     * @return bool
     */
    public function save($id, $obj, $ttl, $serialize = true)
    {
        if (!$this->isSupported()) {
            return false;
        }

        if (!$this->isValidKey($id)) {
            return false;
        }

        $obj = $this->serialize($obj, $serialize);

        return apc_store($id, $obj, $ttl);
    }

    /**
     * @param string $id
     *
     * @return bool|mixed
     */
    public function get($id, $unserialize = true)
    {
        if (!$this->isSupported()) {
            return false;
        }

        if (!$this->isValidKey($id)) {
            return false;
        }

        $obj = apc_fetch($id);

        if ($obj) {
            return $this->unserialize($obj, $unserialize);
        }

        return false;
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function delete($id)
    {
        if (!$this->isSupported()) {
            return false;
        }

        if (!$this->isValidKey($id)) {
            return false;
        }

        return apc_delete($id);
    }

    /**
     * @return bool
     */
    public function isSupported()
    {
        if (function_exists('apc_store')
            && function_exists('apc_fetch')
            && ini_get('apc.enabled')) {
            return true;
        }

        return false;
    }
}
