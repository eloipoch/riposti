<?php

namespace Pablodip\Riposti\Domain\Service\RelationsToLoadLoader;

use Pablodip\Riposti\Domain\Model\Relation\LoadedRelation;
use Pablodip\Riposti\Domain\Model\Relation\RelationToLoad;
use Pablodip\Riposti\Domain\Service\DestinationIdentityMap\DestinationIdentityMapInterface;
use Pablodip\Riposti\Domain\Service\RelationLoader\RelationLoaderInterface;
use Pablodip\Riposti\Domain\Service\RelationTypeProcessor\RelationTypeProcessorInterface;

class RelationsToLoadLoader implements RelationsToLoadLoaderInterface
{
    private $relationTypeProcessorObtainer;
    private $destinationIdentityMap;
    private $loader;

    public function __construct($relationTypeProcessorObtainer, DestinationIdentityMapInterface $destinationIdentityMap, RelationLoaderInterface $loader)
    {
        $this->relationTypeProcessorObtainer = $relationTypeProcessorObtainer;
        $this->destinationIdentityMap = $destinationIdentityMap;
        $this->loader = $loader;
    }

    /**
     * @param $relationsToLoad RelationToLoad[]
     */
    public function __invoke($relationsToLoad, array $relationNamesToLoad = null)
    {
        $idsToLoad = [];

        foreach ($relationsToLoad as $r) {
            if (!is_null($relationNamesToLoad) && !in_array($r->getRelationDefinition()->getName(), $relationNamesToLoad)) {
                continue;
            }

            $destinationDef = $r->getRelationDefinition()->getDestinationDefinition();
            $destionationName = $destinationDef->getName();

            $relationTypeProcessor = $this->getRelationTypeProcessor($r);
            $ids = $relationTypeProcessor->getIdsToLoad($r->getNotLoadedRelation()->getDataToLoad());

            foreach ($ids as $id) {
                if (!$this->destinationIdentityMap->has($destionationName, $id)) {
                    $idsToLoad[$destionationName]['destination'] = $destinationDef;
                    $idsToLoad[$destionationName]['ids'][] = $id;
                }
            }
        }

        foreach ($idsToLoad as $v) {
            /** @var \Pablodip\Riposti\Domain\Metadata\DestinationMetadata $destinationDef */
            $destinationDef = $v['destination'];

            $datas = $this->loader->load($destinationDef->getLoaderInfo(), $v['ids']);
            foreach ($datas as $id => $data) {
                $this->destinationIdentityMap->set($destinationDef->getName(), $id, $data);
            }
        }

        $loadedRelations = [];
        foreach ($relationsToLoad as $r) {
            if (!is_null($relationNamesToLoad) && !in_array($r->getRelationDefinition()->getName(), $relationNamesToLoad)) {
                continue;
            }

            $destinationDef = $r->getRelationDefinition()->getDestinationDefinition();
            $destionationName = $destinationDef->getName();

            $relationTypeProcessor = $this->getRelationTypeProcessor($r);
            $ids = $relationTypeProcessor->getIdsToLoad($r->getNotLoadedRelation()->getDataToLoad());

            $datas = [];
            foreach ($ids as $id) {
                $datas[] = $this->destinationIdentityMap->get($destionationName, $id);
            }

            $loadedRelations[] = new LoadedRelation($r, $relationTypeProcessor->getDataFromLoadedDatas($datas));
        }

        return $loadedRelations;
    }

    /**
     * @return RelationTypeProcessorInterface
     */
    private function getRelationTypeProcessor(RelationToLoad $relationToLoad)
    {
        return call_user_func($this->relationTypeProcessorObtainer, $relationToLoad->getRelationDefinition()->getType());
    }
}
