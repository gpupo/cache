<?php

namespace Gpupo\Cache\Driver;

/**
 * Driver de conexao do PHP com a memoria, utilizando APC
 */
class ApcDriver implements DriverInterface
{
    private $parameters;

    /**
     * Parameters Injection
     *
     * @param \stdClass $parameters
     */
    public function setParameters(\stdClass $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Valida uma string identificadora de objetos
     *
     * @param  string  $id
     * @return boolean
     */
    protected static function isValid($id)
    {
        if (empty($id)) {
            error_log('APC: chamada com id vazio!');

            return false;
        }

        return true;
    }

    /**
     * Guarda o cache de um objeto.
     *
     * @param  string  $id   Gerado por getCacheId
     * @param  mixed   $obj  Valor ou objeto
     * @param  int     $time Em segundos. Por padr�o o valor � 30 minutos(1800)
     * @return boolean
     */
    public function setCache($id, $obj, $time = 1800, $serialize = true)
    {
        if (!function_exists('apc_store')) {
            return false;
        }

        if (!$this->isValid($id)) {
            return false;
        }

        if ($serialize) {
            $obj = serialize($obj);
        }

        $o = apc_store($id, $obj, $time);
        if ($o == false) {
            Logger::addDebug('Impossivel gravar em memoria',
                array(
                    'id' => $id,
                )
            );
        }

        return $o;
    }

    /**
     * Resgata um objeto da mem�ria
     *
     * @param  string  $id Gerado por getCacheId
     * @return boolean
     */
    public function getCache($id, $unserialize = true)
    {
        if (!function_exists('apc_fetch')) {
            return false;
        }

        if (!$this->isValid($id)) {
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
    public function clearCache($id)
    {
        if (!function_exists('apc_delete')) {
            return false;
        }

        if (!$this->isValid($id)) {
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
