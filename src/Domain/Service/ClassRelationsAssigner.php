<?php

namespace Pablodip\Riposti\Domain\Service;

use Pablodip\Riposti\Domain\Model\ClassRelations\ClassRelationsDefinition;
use Pablodip\Riposti\Domain\Model\Relation\RelationLoaded;
use Pablodip\Riposti\Domain\Model\Relation\RelationToLoad;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\RelationDataAccessorInterface;

class ClassRelationsAssigner
{
    private $dataAccessor;

    public function __construct(RelationDataAccessorInterface $dataAccessor)
    {
        $this->dataAccessor = $dataAccessor;
    }

    /**
     * @param $classRelationsObtainer
     * @param $loadedRelations RelationLoaded[]
     */
    public function __invoke($classRelationsObtainer, $loadedRelations, $objs)
    {
        foreach ($loadedRelations as $r) {
            foreach ($objs as $o) {
                if ($this->objHasRelationToLoad($classRelationsObtainer, $o, $r->getRelationToLoad())) {
                    $relationName = $r->getRelationToLoad()->getRelationDefinition()->getName();
                    $data = $r->getData();

                    $this->dataAccessor->set($o, $relationName, $data);
                }
            }
        }
    }

    private function objHasRelationToLoad($classRelationsObtainer, $obj, RelationToLoad $relationToLoad)
    {
        /** @var ClassRelationsDefinition $classRelationsDef */
        $classRelationsDef = $classRelationsObtainer(get_class($obj));

        foreach ($classRelationsDef->getRelationsDefinitions() as $r) {
            $dataToLoad = $this->dataAccessor->get($obj, $r->getName());

            if ($relationToLoad->getNotLoadedRelation() == $dataToLoad) {
                return true;
            }
        }

        return false;
    }
}
