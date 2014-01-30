<?php

namespace Pablodip\Riposti\Domain\Model\ClassRelations;

use Pablodip\Riposti\Domain\Model\Relation\RelationDefinition;

class ClassRelationsDefinition
{
    private $class;
    private $relationsDefinitions;

    public function __construct($class, $relationsDefinitions)
    {
        $this->class     = $class;
        $this->relationsDefinitions = $relationsDefinitions;
    }

    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return RelationDefinition[]
     */
    public function getRelationsDefinitions()
    {
        return $this->relationsDefinitions;
    }
}
