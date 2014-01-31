<?php

namespace Pablodip\Riposti\Domain\Service\ClassRelationsDefinitionObtainer;

use Pablodip\Riposti\Domain\Model\ClassRelations\ClassRelationsDefinition;
use Pablodip\Riposti\Domain\Model\Destination\DestinationDefinition;
use Pablodip\Riposti\Domain\Model\Relation\RelationDefinition;

class RelationsDestinationsClassRelationsDefinitionObtainer
{
    private $classRelationsDefs = [];

    public function __construct($relationsInfo, $destinationsInfo)
    {
        $destinations = [];
        foreach ($destinationsInfo as $name => $destinationInfo) {
            $destinations[$name] = new DestinationDefinition($name, $destinationInfo['loader_info']);
        }

        foreach ($relationsInfo as $class => $relationInfoses) {
            $relations = [];
            foreach ($relationInfoses as $name => $relationInfo) {
                $relations[] = new RelationDefinition($name, $relationInfo['type'], $destinations[$relationInfo['destination']]);
            }

            $this->classRelationsDefs[$class] = new ClassRelationsDefinition($class, $relations);
        }
    }

    public function __invoke($class)
    {
        if (!isset($this->classRelationsDefs[$class])) {
            throw new \RuntimeException(sprintf('The class "%s" does not have class relations defined.', $class));
        }

        return $this->classRelationsDefs[$class];
    }
}
