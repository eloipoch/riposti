<?php

namespace Pablodip\Riposti\Domain\Service\RelationsToLoadSearcher;

use Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata;
use Pablodip\Riposti\Domain\Model\NotLoadedRelation\NotLoadedRelationInterface;
use Pablodip\Riposti\Domain\Model\Relation\RelationToLoad;
use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\RelationDataAccessorInterface;

class RelationsToLoadSearcher implements RelationsToLoadSearcherInterface
{
    private $dataAccessor;

    public function __construct(RelationDataAccessorInterface $dataAccessor)
    {
        $this->dataAccessor = $dataAccessor;
    }

    public function __invoke(ClassRelationsMetadataObtainerInterface $classRelationsMetadataObtainer, $objs)
    {
        $relationsToLoad = [];
        foreach ($objs as $o) {
            $classRelationDefs = $classRelationsMetadataObtainer(get_class($o));
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
