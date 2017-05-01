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
