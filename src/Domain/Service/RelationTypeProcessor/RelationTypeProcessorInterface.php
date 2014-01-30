<?php

namespace Pablodip\Riposti\Domain\Service\RelationTypeProcessor;

interface RelationTypeProcessorInterface
{
    function getIdsToLoad($dataToLoad);

    function getDataFromLoadedDatas($datas);
}
