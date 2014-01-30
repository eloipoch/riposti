<?php

namespace Pablodip\Riposti\Domain\Service\DestinationIdentityMap;

interface DestinationIdentityMapInterface
{
    function has($destinationName, $id);

    function get($destinationName, $id);

    function set($destinationName, $id, $obj);
}
