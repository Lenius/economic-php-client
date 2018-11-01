<?php

namespace Lenius\Economic\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

abstract class BaseTest extends TestCase
{
    /**
     * getPrivateProperty.
     *
     * @author    Joe Sexton <joe@webtipblog.com>
     *
     * @param string $className
     * @param string $propertyName
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionProperty
     */
    public function getPrivateProperty($className, $propertyName)
    {
        $reflector = new ReflectionClass($className);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }

    /**
     * getPrivateMethod.
     *
     * @author    Joe Sexton <joe@webtipblog.com>
     *
     * @param string $className
     * @param string $methodName
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionMethod
     */
    public function getPrivateMethod($className, $methodName)
    {
        $reflector = new ReflectionClass($className);
        $method = $reflector->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * getConstants.
     *
     * @param string $className
     *
     * @throws \ReflectionException
     *
     * @return array
     */
    public function getConstants($className)
    {
        $oClass = new ReflectionClass($className);

        return $oClass->getConstants();
    }
}
