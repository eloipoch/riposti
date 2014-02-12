<?php

namespace Pablodip\Riposti\Domain\Service\RelationDataAccessor;

use ReflectionClass;

class PropertyReflectionRelationDataAccessor implements RelationDataAccessorInterface
{
    public function get($obj, $name)
    {
        return $this->getReflectionProperty($obj, $name)->getValue($obj);
    }

    public function set($obj, $name, $data)
    {
        $this->getReflectionProperty($obj, $name)->setValue($obj, $data);
    }

    private function getReflectionProperty($obj, $name)
    {
        $refClass = new ReflectionClass(get_class($obj));

        $refProp = $this->findProperty($name, $refClass);
        $refProp->setAccessible(true);

        return $refProp;
    }

    private function findProperty($name, ReflectionClass $refClass)
    {
        if (!$refClass->hasProperty($name)) {
            $refClass = $refClass->getParentClass();
        }

        return $refClass->getProperty($name);
    }
}
