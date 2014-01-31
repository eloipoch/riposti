<?php

namespace Pablodip\Riposti\Domain\Service\RelationTypeProcessorObtainer;

use Pablodip\Riposti\Domain\Service\RelationTypeProcessor\OneRelationTypeProcessor;

class DefaultRelationTypeProcessorObtainer
{
    private $types;

    public function __construct()
    {
        $this->types = [
            'one' => new OneRelationTypeProcessor()
        ];
    }

    public function __invoke($type)
    {
        if (!isset($this->types[$type])) {
            throw new \RuntimeException(sprintf('The riposti relation type processor "%s" does not exist.', $type));
        }

        return $this->types[$type];
    }
}
