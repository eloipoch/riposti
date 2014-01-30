<?php

namespace Pablodip\Riposti\Domain\Model\Relation;

use Pablodip\Riposti\Domain\Model\NotLoadedRelation\NotLoadedRelationInterface;

class RelationToLoad
{
    private $relationDefinition;
    private $notLoadedRelation;

    public function __construct(RelationDefinition $relationDefinition, NotLoadedRelationInterface $notLoadedRelation)
    {
        $this->notLoadedRelation = $notLoadedRelation;
        $this->relationDefinition = $relationDefinition;
    }

    public function getNotLoadedRelation()
    {
        return $this->notLoadedRelation;
    }

    public function getRelationDefinition()
    {
        return $this->relationDefinition;
    }
}
