<?php

namespace Pablodip\Riposti\Domain;

class RipostiLoader
{
    private $classRelationsObtainer;
    private $relationsToLoadSearcher;
    private $relationsToLoadLoader;
    private $classRelationsAssigner;

    public function __construct($classRelationsObtainer, $relationsToLoadSearcher, $relationsToLoadLoader, $classRelationsAssigner)
    {
        $this->classRelationsAssigner  = $classRelationsAssigner;
        $this->classRelationsObtainer  = $classRelationsObtainer;
        $this->relationsToLoadLoader   = $relationsToLoadLoader;
        $this->relationsToLoadSearcher = $relationsToLoadSearcher;
    }

    public function load($objs, array $relationNamesToLoad = null)
    {
        if (!is_array($objs)) {
            $objs = [$objs];
        }

        $relationsToLoad = call_user_func($this->relationsToLoadSearcher, $this->classRelationsObtainer, $objs);
        if (is_null($relationNamesToLoad)) {
            $loadedRelations = call_user_func($this->relationsToLoadLoader, $relationsToLoad);
        } else {
            $loadedRelations = call_user_func($this->relationsToLoadLoader, $relationsToLoad, $relationNamesToLoad);
        }
        call_user_func($this->classRelationsAssigner, $this->classRelationsObtainer, $loadedRelations, $objs);
    }
}
