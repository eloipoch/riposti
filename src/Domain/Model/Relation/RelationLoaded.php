<?php

namespace Pablodip\Riposti\Domain\Model\Relation;

class RelationLoaded
{
    private $relationToLoad;
    private $data;

    public function __construct(RelationToLoad $relationToLoad, $data)
    {
        $this->data           = $data;
        $this->relationToLoad = $relationToLoad;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getRelationToLoad()
    {
        return $this->relationToLoad;
    }
}
