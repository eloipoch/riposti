<?php

namespace Pablodip\Riposti\Domain\Service\ClassRelationsAssigner;

use Pablodip\Riposti\Domain\Model\Relation\LoadedRelation;
use Pablodip\Riposti\Domain\Model\Relation\RelationToLoad;
use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;
use Pablodip\Riposti\Domain\Service\RelationDataAccessor\RelationDataAccessorInterface;

class ClassRelationsAssigner implements ClassRelationsAssignerInterface
{
    private $dataAccessor;

    public function __construct(RelationDataAccessorInterface $dataAccessor)
    {
        $this->dataAccessor = $dataAccessor;
    }

    /**
     * @param $classRelationsMetadataObtainer
     * @param $loadedRelations LoadedRelation[]
     */
    public function __invoke(ClassRelationsMetadataObtainerInterface $classRelationsMetadataObtainer, $loadedRelations, $objs)
    {
        foreach ($loadedRelations as $r) {
            foreach ($objs as $o) {
                if ($this->objHasRelationToLoad($classRelationsMetadataObtainer, $o, $r->getRelationToLoad())) {
                    $relationName = $r->getRelationToLoad()->getRelationDefinition()->getName();
                    $data = $r->getData();

                    $this->dataAccessor->set($o, $relationName, $data);
                }
            }
        }
    }

    private function objHasRelationToLoad(ClassRelationsMetadataObtainerInterface $classRelationsObtainer, $obj, RelationToLoad $relationToLoad)
    {
        $classRelationsDef = $classRelationsObtainer->__invoke(get_class($obj));

        foreach ($classRelationsDef->getRelationsDefinitions() as $r) {
            $dataToLoad = $this->dataAccessor->get($obj, $r->getName());

            if ($relationToLoad->getNotLoadedRelation() == $dataToLoad) {
                return true;
            }
        }

        return false;
    }
}
