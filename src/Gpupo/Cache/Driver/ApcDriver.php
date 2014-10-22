<?php

namespace Gpupo\Cache\Driver;

/**
 * Driver de conexao do PHP com a memoria, utilizando APC
 */
class ApcDriver extends DriverAbstract implements DriverInterface
{
    /**
     * @param  string  $id   Gerado por getCacheId
     * @param  mixed   $obj  Valor ou objeto
     * @param  int     $time Em segundos. Por padr�o o valor � 30 minutos(1800)
     * @return boolean
     */
    public function save($id, $obj, $time = 1800, $serialize = true)
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

        return apc_store($id, $obj, $time);
    }

    /**
     *
     * @param  string  $id Gerado por getCacheId
     * @return boolean
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
     * Limpa o cache de um objeto
     *
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
     * Verifica se o servidor Web tem suporte ao driver configurado
     *
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
