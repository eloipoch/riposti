<?php

namespace Pablodip\Riposti\Domain\Service;

use Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata;
use Pablodip\Riposti\Domain\Model\NotLoadedRelation\NotLoadedRelationInterface;
use Pablodip\Riposti\Domain\Model\Relation\RelationToLoad;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\RelationDataAccessorInterface;

class RelationsToLoadSearcher
{
    private $dataAccessor;

    public function __construct(RelationDataAccessorInterface $dataAccessor)
    {
        $this->dataAccessor = $dataAccessor;
    }

    public function __invoke($classRelationsObtainer, $objs)
    {
        $relationsToLoad = [];
        foreach ($objs as $o) {
            /** @var \Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata $classRelationDefs */
            $classRelationDefs = $classRelationsObtainer(get_class($o));
            $relationsToLoadForObj = $this->findRelationsToLoadForObj($classRelationDefs, $o);
            $relationsToLoad = array_merge($relationsToLoad, $relationsToLoadForObj);
        }

        return $relationsToLoad;
    }

    private function findRelationsToLoadForObj(ClassRelationsMetadata $classRelationDefs, $o)
    {
        $relationsToLoad = [];
        foreach ($classRelationDefs->getRelationsDefinitions() as $r) {
            /** @var NotLoadedRelationInterface $relation */
            $relation = $this->dataAccessor->get($o, $r->getName());

            if (!$relation instanceof NotLoadedRelationInterface) {
                continue;
            }

            $relationsToLoad[] = new RelationToLoad($r, $relation);
        }

        return $relationsToLoad;
    }
}
