<?php

namespace Pablodip\Riposti\Domain;

use Pablodip\Riposti\Domain\Service\ClassRelationsAssigner\ClassRelationsAssignerInterface;
use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;
use Pablodip\Riposti\Domain\Service\RelationsToLoadLoader\RelationsToLoadLoaderInterface;
use Pablodip\Riposti\Domain\Service\RelationsToLoadSearcher\RelationsToLoadSearcherInterface;

class RipostiLoader
{
    private $classRelationsMetadataObtainer;
    private $relationsToLoadSearcher;
    private $relationsToLoadLoader;
    private $classRelationsAssigner;

    public function __construct(
        ClassRelationsMetadataObtainerInterface $classRelationsMetadataObtainer,
        RelationsToLoadSearcherInterface $relationsToLoadSearcher,
        RelationsToLoadLoaderInterface $relationsToLoadLoader,
        ClassRelationsAssignerInterface $classRelationsAssigner
    )
    {
        $this->classRelationsAssigner  = $classRelationsAssigner;
        $this->classRelationsMetadataObtainer  = $classRelationsMetadataObtainer;
        $this->relationsToLoadLoader   = $relationsToLoadLoader;
        $this->relationsToLoadSearcher = $relationsToLoadSearcher;
    }

    public function load($objs, array $relationNamesToLoad = null)
    {
        if (!is_array($objs)) {
            $objs = [$objs];
        }

        $relationsToLoad = $this->relationsToLoadSearcher->__invoke($this->classRelationsMetadataObtainer, $objs);
        if (is_null($relationNamesToLoad)) {
            $loadedRelations = $this->relationsToLoadLoader->__invoke($relationsToLoad);
        } else {
            $loadedRelations = $this->relationsToLoadLoader->__invoke($relationsToLoad, $relationNamesToLoad);
        }
        $this->classRelationsAssigner->__invoke($this->classRelationsMetadataObtainer, $loadedRelations, $objs);
    }
}
