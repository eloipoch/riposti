<?php

namespace Pablodip\Riposti\Domain\Service\RelationTypeProcessor;

class OneRelationTypeProcessor implements RelationTypeProcessorInterface
{
    public function getIdsToLoad($dataToLoad)
    {
        return [$dataToLoad];
    }

    public function getDataFromLoadedDatas($datas)
    {
        return $datas[0];
    }
}
