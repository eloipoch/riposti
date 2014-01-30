<?php

namespace Pablodip\Riposti\Domain\Model\NotLoadedRelation;

class IdOneTypeNotLoadedRelation implements NotLoadedRelationInterface
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDataToLoad()
    {
        return $this->id;
    }

    public function __call($method, $args)
    {
        throw new \RuntimeException('This relation is not loaded');
    }
}
