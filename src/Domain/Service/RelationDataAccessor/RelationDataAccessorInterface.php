<?php

namespace Pablodip\Riposti\Domain\Service\RelationDataAccessor;

interface RelationDataAccessorInterface
{
    function get($obj, $name);

    function set($obj, $name, $data);
}
