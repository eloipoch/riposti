<?php

namespace Pablodip\Riposti\Domain;

use Pablodip\Riposti\Domain\Service\ClassRelationsAssigner;
use Pablodip\Riposti\Domain\Service\DestinationIdentityMap\DestinationIdentityMap;
use Pablodip\Riposti\Domain\Service\RelationsToLoadLoader;
use Pablodip\Riposti\Domain\Service\RelationsToLoadSearcher;
use Pablodip\Riposti\Domain\Service\RelationTypeProcessorObtainer\DefaultRelationTypeProcessorObtainer;

class RipostiLoaderBuilder
{
    private $classRelationsDefinitionObtainer;
    private $relationDataAccessor;
    private $relationLoader;

    public function __construct($classRelationsDefinitionObtainer, $relationDataAccessor, $relationLoader)
    {
        $this->classRelationsDefinitionObtainer = $classRelationsDefinitionObtainer;
        $this->relationDataAccessor             = $relationDataAccessor;
        $this->relationLoader                   = $relationLoader;
    }

    /**
     * @return RipostiLoader
     */
    public function build()
    {
        return new RipostiLoader(
            $this->classRelationsDefinitionObtainer,
            new RelationsToLoadSearcher($this->relationDataAccessor),
            new RelationsToLoadLoader(
                $this->createRelationTypeProcessorObtainer(),
                $this->createDestinationIdentityMap(),
                $this->relationLoader
            ),
            new ClassRelationsAssigner($this->relationDataAccessor)
        );
    }

    private function createRelationTypeProcessorObtainer()
    {
        return new DefaultRelationTypeProcessorObtainer();
    }

    private function createDestinationIdentityMap()
    {
        return new DestinationIdentityMap();
    }
}
