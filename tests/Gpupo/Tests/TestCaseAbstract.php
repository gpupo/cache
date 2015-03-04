<?php

namespace Gpupo\Tests;

abstract class TestCaseAbstract extends \PHPUnit_Framework_TestCase
{
    protected function getConstant($name, $default = false)
    {
        if (defined($name)) {
            return constant($name);
        }

        return $default;
    }
}
