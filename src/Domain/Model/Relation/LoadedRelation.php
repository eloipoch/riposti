<?php

namespace Pablodip\Riposti\Domain\Model\Relation;

class LoadedRelation
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
