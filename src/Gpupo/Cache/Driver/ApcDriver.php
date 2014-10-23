<?php

namespace Gpupo\Cache\Driver;

/**
 * Driver de conexao do PHP com a memoria, utilizando APC
 */
class ApcDriver extends DriverAbstract implements DriverInterface
{
    /**
     * @param  string  $id
     * @param  mixed   $obj
     * @param  int     $ttl
     * @return boolean
     */
    public function save($id, $obj, $ttl, $serialize = true)
    {
        if (!$this->isSupported()) {
            return false;
        }

        if (!$this->isValidKey($id)) {
            return false;
        }

        if ($serialize) {
            $obj = serialize($obj);
        }

        return apc_store($id, $obj, $ttl;
    }

    /**
     * @param  string  $id
     * @return boolean|mixed
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

        if ($obj !== false) {
            if (!$unserialize) {
                return $obj;
            } else {
                return unserialize($obj);
            }
        }

        return false;
    }

    /**
     * @param  string  $id
     * @return boolean
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
     * @return boolean
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
