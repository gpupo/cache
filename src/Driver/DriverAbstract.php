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
