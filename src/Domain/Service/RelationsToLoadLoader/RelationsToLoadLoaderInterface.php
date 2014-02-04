<?php

namespace Pablodip\Riposti\Domain\Service\RelationsToLoadLoader;

interface RelationsToLoadLoaderInterface
{
    function __invoke($relationsToLoad, array $relationNamesToLoad = null);
}
