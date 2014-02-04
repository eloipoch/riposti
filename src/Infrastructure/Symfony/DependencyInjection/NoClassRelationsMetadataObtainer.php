<?php

namespace Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection;

use Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata;
use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;

class NoClassRelationsMetadataObtainer implements ClassRelationsMetadataObtainerInterface
{
    /**
     * @return ClassRelationsMetadata
     */
    public function __invoke($class)
    {
        throw new \RuntimeException('You must configure the class relations metadata obtainer.');
    }
}
