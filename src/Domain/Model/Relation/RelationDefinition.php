<?php

namespace Pablodip\Riposti\Domain\Model\Relation;

use Pablodip\Riposti\Domain\Model\Destination\DestinationDefinition;

class RelationDefinition
{
    private $name;
    private $type;
    private $destinationDefinition;

    public function __construct($name, $type, DestinationDefinition $destinationDefinition)
    {
        $this->destinationDefinition = $destinationDefinition;
        $this->type = $type;
        $this->name = $name;
    }

    public function getDestinationDefinition()
    {
        return $this->destinationDefinition;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getName()
    {
        return $this->name;
    }
}
