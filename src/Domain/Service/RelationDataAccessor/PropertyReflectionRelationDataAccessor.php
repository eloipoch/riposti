<?php

namespace Pablodip\Riposti\Domain\Service\RelationDataAccessor;

use ReflectionClass;

class PropertyReflectionRelationDataAccessor implements RelationDataAccessorInterface
{
    public function get($obj, $name)
    {
        $refClass = new ReflectionClass(get_class($obj));

        $refProp = $refClass->getProperty($name);
        $refProp->setAccessible(true);

        return $refProp->getValue($obj);
    }

    public function set($obj, $name, $data)
    {
        $refClass = new ReflectionClass(get_class($obj));

        $refProp = $refClass->getProperty($name);
        $refProp->setAccessible(true);

        $refProp->setValue($obj, $data);
    }
}
