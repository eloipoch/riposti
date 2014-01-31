<?php

namespace Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection;

use Pablodip\Riposti\Domain\Service\RelationLoader\RelationLoaderInterface;

class NoRelationLoader implements RelationLoaderInterface
{
    public function load($loaderInfo, $ids)
    {
        throw new \RuntimeException('You must implement the relation loader.');
    }
}
