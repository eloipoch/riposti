<?php

namespace Pablodip\Riposti\Domain\Service\RelationLoader;

interface RelationLoaderInterface
{
    function load($loaderInfo, $ids);
}
