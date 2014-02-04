<?php

namespace Pablodip\Riposti\Domain\Metadata;

class ClassRelationsMetadata
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
     * @return RelationMetadata[]
     */
    public function getRelationsDefinitions()
    {
        return $this->relationsDefinitions;
    }
}
