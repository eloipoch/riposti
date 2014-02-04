<?php

namespace Pablodip\Riposti\Domain\Metadata;

class DestinationMetadata
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
