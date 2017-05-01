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

use Gpupo\Common\Traits\OptionsTrait;
use Gpupo\Common\Traits\SingletonTrait;

abstract class DriverAbstract
{
    use SingletonTrait;
    use OptionsTrait;

    public function generateId($key, $prefix = null)
    {
        if (is_array($key)) {
            $sha1 = sha1(serialize($key));
        } else {
            $sha1 = sha1($key);
        }

        return $prefix.$sha1;
    }

    protected function isValidKey($key)
    {
        if (empty($key)) {
            return false;
        }

        return true;
    }

    public function serialize($obj, $serialize = true)
    {
        return serialize($obj);
    }

    public function unserialize($string, $unserialize = true)
    {
        if (!$unserialize) {
            return $string;
        }

        return unserialize($string);
    }
}
