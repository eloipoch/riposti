<?php

namespace Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer;

use Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata;
use Pablodip\Riposti\Domain\Metadata\DestinationMetadata;
use Pablodip\Riposti\Domain\Metadata\RelationMetadata;

class RelationsDestinationsClassRelationsMetadataObtainer implements ClassRelationsMetadataObtainerInterface
{
    private $classRelationsDefs = [];

    public function __construct($relationsInfo, $destinationsInfo)
    {
        $destinations = [];
        foreach ($destinationsInfo as $name => $destinationInfo) {
            $destinations[$name] = new DestinationMetadata($name, $destinationInfo['loader_info']);
        }

        foreach ($relationsInfo as $class => $relationInfoses) {
            $relations = [];
            foreach ($relationInfoses as $name => $relationInfo) {
                $relations[] = new RelationMetadata($name, $relationInfo['type'], $destinations[$relationInfo['destination']]);
            }

            $this->classRelationsDefs[$class] = new ClassRelationsMetadata($class, $relations);
        }
    }

    public function __invoke($classMetadata)
    {
        if (!isset($this->classRelationsDefs[$classMetadata])) {
            throw new \RuntimeException(sprintf('The class "%s" does not have class relations defined.', $classMetadata));
        }

        return $this->classRelationsDefs[$classMetadata];
    }
}
