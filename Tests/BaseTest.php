<?php

namespace Lenius\Economic\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

abstract class BaseTest extends TestCase
{

    /**
     * getPrivateProperty
     *
     * @author    Joe Sexton <joe@webtipblog.com>
     *
     * @param    string $className
     * @param    string $propertyName
     *
     * @return \ReflectionProperty
     * @throws \ReflectionException
     */
    public function getPrivateProperty($className, $propertyName)
    {
        $reflector = new ReflectionClass($className);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }

    /**
     * getPrivateMethod
     *
     * @author    Joe Sexton <joe@webtipblog.com>
     *
     * @param    string $className
     * @param    string $methodName
     *
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    public function getPrivateMethod($className, $methodName)
    {
        $reflector = new ReflectionClass($className);
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * getConstants
     *
     * @param string $className
     *
     * @return array
     * @throws \ReflectionException
     */
    public function getConstants($className)
    {
        $oClass = new ReflectionClass($className);

        return $oClass->getConstants();
    }

}
