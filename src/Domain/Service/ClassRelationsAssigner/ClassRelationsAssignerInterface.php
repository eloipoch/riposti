<?php

namespace Pablodip\Riposti\Domain\Service\ClassRelationsAssigner;

use Pablodip\Riposti\Domain\Service\ClassRelationsMetadataObtainer\ClassRelationsMetadataObtainerInterface;

interface ClassRelationsAssignerInterface
{
    function __invoke(ClassRelationsMetadataObtainerInterface $classRelationsMetadataObtainer, $loadedRelations, $objs);
}
