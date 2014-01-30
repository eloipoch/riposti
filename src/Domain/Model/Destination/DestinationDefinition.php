<?php

namespace Pablodip\Riposti\Domain\Model\Destination;

class DestinationDefinition
{
    private $name;
    private $loaderInfo;

    public function __construct($name, $loaderInfo)
    {
        $this->loaderInfo = $loaderInfo;
        $this->name       = $name;
    }

    public function getLoaderInfo()
    {
        return $this->loaderInfo;
    }

    public function getName()
    {
        return $this->name;
    }
}
