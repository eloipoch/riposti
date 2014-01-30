<?php

namespace Pablodip\Riposti\Domain\Service\RelationLoader;

class CallableRelationLoader implements RelationLoaderInterface
{
    public function load($loaderInfo, $ids)
    {
        return $loaderInfo($ids);
    }
}
