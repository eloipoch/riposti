<?php

namespace Pablodip\Riposti\Domain\Service\RelationsToLoadSearcher;

use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;

interface RelationsToLoadSearcherInterface
{
    function __invoke(ClassRelationsMetadataObtainerInterface $classRelationsMetadataMetadataObtainer, $objs);
}
