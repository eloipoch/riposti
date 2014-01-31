<?php

namespace Pablodip\Riposti\Infrastructure\Symfony\DependencyInjection;

class NoClassRelationsDefinitionObtainer
{
    public function __invoke()
    {
        throw new \RuntimeException('You must configure the class relations definition obtainer.');
    }
}
