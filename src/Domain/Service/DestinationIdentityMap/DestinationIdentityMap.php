<?php

namespace Pablodip\Riposti\Domain\Service\DestinationIdentityMap;

class DestinationIdentityMap implements DestinationIdentityMapInterface
{
    private $objs;

    public function has($destinationName, $id)
    {
        return isset($this->objs[$destinationName][$id]);
    }

    public function get($destinationName, $id)
    {
        if (!isset($this->objs[$destinationName])) {
            throw new \RuntimeException(sprintf('The destination identity map does not have the destination "%s".', $destinationName));
        }

        return $this->objs[$destinationName][$id];
    }

    public function set($destinationName, $id, $obj)
    {
        $this->objs[$destinationName][$id] = $obj;
    }
}
