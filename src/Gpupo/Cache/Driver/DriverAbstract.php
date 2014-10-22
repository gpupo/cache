<?php

namespace Gpupo\Cache\Driver;

abstract class DriverAbstract
{
    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $class=get_called_class();
            self::$instance = new $class();
        }

        return self::$instance;
    }

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
