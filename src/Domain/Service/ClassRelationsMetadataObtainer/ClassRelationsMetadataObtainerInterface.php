<?php

namespace Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer;

use Pablodip\Riposti\Domain\Metadata\ClassRelationsMetadata;

interface ClassRelationsMetadataObtainerInterface
{
    /**
     * @return ClassRelationsMetadata
     */
    function __invoke($classMetadata);
}
