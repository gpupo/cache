<?php

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

        return $prefix . $sha1;
    }

    protected function isValidKey($key)
    {
        if (empty($key)) {
            return false;
        }

        return true;
    }
}
