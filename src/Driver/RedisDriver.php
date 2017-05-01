<?php

/*
 * This file is part of gpupo/cache
 * Created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file
 * LICENSE which is distributed with this source code.
 * Para a informação dos direitos autorais e de licença você deve ler o arquivo
 * LICENSE que é distribuído com este código-fonte.
 * Para obtener la información de los derechos de autor y la licencia debe leer
 * el archivo LICENSE que se distribuye con el código fuente.
 * For more information, see <https://www.gpupo.com/>.
 */

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

        return $this->redisClient->set($id, $obj, 'ex', $ttl);
    }

    public function get($id, $unserialize = true)
    {
        $value = $this->redisClient->get($id);
        if ($value === null) {
            return;
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
