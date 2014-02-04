<?php

namespace Pablodip\Riposti\Domain;

use Pablodip\Riposti\Domain\Service\ClassRelationsAssigner\ClassRelationsAssigner;
use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;
use Pablodip\Riposti\Domain\Service\DestinationIdentityMap\DestinationIdentityMap;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\RelationDataAccessorInterface;
use Pablodip\Riposti\Domain\Service\RelationLoader\RelationLoaderInterface;
use Pablodip\Riposti\Domain\Service\RelationsToLoadLoader\RelationsToLoadLoader;
use Pablodip\Riposti\Domain\Service\RelationsToLoadSearcher\RelationsToLoadSearcher;
use Pablodip\Riposti\Domain\Service\RelationTypeProcessorObtainer\DefaultRelationTypeProcessorObtainer;

class RipostiLoaderBuilder
{
    private $classRelationsMetadataObtainer;
    private $relationDataAccessor;
    private $relationLoader;

    public function __construct(ClassRelationsMetadataObtainerInterface $classRelationsMetadataObtainer, RelationDataAccessorInterface $relationDataAccessor, RelationLoaderInterface $relationLoader)
    {
        $this->classRelationsMetadataObtainer = $classRelationsMetadataObtainer;
        $this->relationDataAccessor             = $relationDataAccessor;
        $this->relationLoader                   = $relationLoader;
    }

    /**
     * @return RipostiLoader
     */
    public function build()
    {
        return new RipostiLoader(
            $this->classRelationsMetadataObtainer,
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
